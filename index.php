<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Categories.php';

session_start();
$db = Database::getInstance();
$error = $success = '';

// Handle transaction deletion
if (isset($_POST['delete']) && isset($_POST['id'])) {
    try {
        $db->query('DELETE FROM transactions WHERE id = :id', [':id' => $_POST['id']]);
        $success = 'Transaction deleted successfully!';
    } catch (Exception $e) {
        $error = 'Error deleting transaction: ' . $e->getMessage();
    }
}

// Fetch all transactions
$result = $db->query('
    SELECT * FROM transactions 
    ORDER BY transaction_date DESC, created_at DESC
');

$transactions = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $transactions[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Wallet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .toast {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            padding: 1rem;
            background: #4CAF50;
            color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: none;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php if (isset($_SESSION['transaction_success'])): ?>
        <div id="toast" class="toast">
            Successfully added <?php echo htmlspecialchars($_SESSION['transaction_type']); ?>: 
            $<?php echo number_format($_SESSION['transaction_amount'], 2); ?>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('toast');
                toast.style.display = 'block';
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 3000);
            });
        </script>
        <?php
        // Clear the session variables
        unset($_SESSION['transaction_success']);
        unset($_SESSION['transaction_type']);
        unset($_SESSION['transaction_amount']);
        ?>
    <?php endif; ?>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Personal Wallet</h1>
            <a href="add_transaction.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Transaction
            </a>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($transactions as $transaction): ?>
                        <?php 
                        $amount = $transaction['amount'];
                        $isExpense = $amount < 0;
                        $amountClass = $isExpense ? 'text-red-600' : 'text-green-600';
                        
                        // Get category display name
                        $categoryId = $transaction['category'];
                        $categoryName = $categoryId;
                        
                        if (is_numeric($categoryId)) {
                            if ($isExpense) {
                                $categoryName = Categories::getCategoryPath($categoryId) ?? $categoryId;
                            } else {
                                $categoryName = Categories::getCategoryPath($categoryId) ?? $categoryId;
                            }
                        }
                        ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo htmlspecialchars($transaction['transaction_date']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo htmlspecialchars($transaction['description']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo htmlspecialchars($categoryName); ?>
                            </td>
                            <td class="px-6 py-4 <?php echo $amountClass; ?>">
                                <?php echo number_format($amount, 2); ?>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['id']); ?>">
                                    <button type="submit" name="delete" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No transactions found. Add your first transaction!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

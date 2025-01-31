<?php require_once __DIR__ . '/includes/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
  $description = trim($_POST['description'] ?? '');
  $category = trim($_POST['category'] ?? '');
  $date = trim($_POST['date'] ?? '');
  $type = trim($_POST['type'] ?? 'expense');

  if (!$amount) {
    $error = 'Please enter a valid amount';
  } elseif (empty($category)) {
    $error = 'Please select a category';
  } elseif (empty($date)) {
    $error = 'Please select a date';
  } else {
    try {
      // Convert amount to negative if it's an expense
      $finalAmount = $type === 'expense' ? -abs($amount) : abs($amount);

      $db->query(
        'INSERT INTO transactions (amount, description, category, transaction_date) VALUES (:amount, :description, :category, :date)',
        [
          ':amount' => $finalAmount,
          ':description' => $description,
          ':category' => $category,
          ':date' => $date
        ]
      );

      // Store success message in session
      session_start();
      $_SESSION['transaction_success'] = true;
      $_SESSION['transaction_type'] = $type;
      $_SESSION['transaction_amount'] = abs($amount);

      header('Location: index.php');
      exit;
    } catch (Exception $e) {
      $error = 'Error adding transaction: ' . $e->getMessage();
    }
  }
}
?>

<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Add Transaction</h1>
      <a href="index.php" class="text-blue-500 hover:text-blue-600">← Back to Transactions</a>
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

    <div class="bg-white rounded-lg shadow-md p-6">
      <form method="POST" class="space-y-4">
        <div>
          <label for="type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
          <select name="type" id="type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            onchange="updateCategories(this.value)"
            required>
            <option value="expense" <?php echo (isset($_POST['type']) && $_POST['type'] === 'expense') ? 'selected' : ''; ?>>Expense</option>
            <option value="income" <?php echo (isset($_POST['type']) && $_POST['type'] === 'income') ? 'selected' : ''; ?>>Income</option>
          </select>
        </div>

        <div>
          <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
          <input type="number" inputmode="decimal" step="0.01" name="amount" id="amount"
            value="<?php echo htmlspecialchars($_POST['amount'] ?? ''); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            required>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
          <input type="text" name="description" id="description"
            value="<?php echo htmlspecialchars($_POST['description'] ?? ''); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
          <select name="category" id="category"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            required>
            <option value="">Select a category</option>
            <?php
            // Add expense categories
            $expenseCategories = Categories::getExpenseCategories();
            foreach ($expenseCategories as $categoryId => $category) {
              if (isset($category['subcategories'])) {
                // If category has subcategories, create an optgroup
                echo '<optgroup label="' . htmlspecialchars($category['name']) . '" data-type="expense">';
                foreach ($category['subcategories'] as $subId => $subName) {
                  $selected = (isset($_POST['category']) && $_POST['category'] == $subId) ? ' selected' : '';
                  echo '<option value="' . $subId . '" data-type="expense"' . $selected . '>'
                    . htmlspecialchars($subName) . '</option>';
                }
                echo '</optgroup>';
              } else {
                // If category has no subcategories, add it as a direct option
                $selected = (isset($_POST['category']) && $_POST['category'] == $categoryId) ? ' selected' : '';
                echo '<option value="' . $categoryId . '" data-type="expense"' . $selected . '>'
                  . htmlspecialchars($category['name']) . '</option>';
              }
            }

            // Add income categories
            $incomeCategories = Categories::getIncomeCategories();
            foreach ($incomeCategories as $categoryId => $category) {
              $selected = (isset($_POST['category']) && $_POST['category'] == $categoryId) ? ' selected' : '';
              echo '<option value="' . $categoryId . '" data-type="income"' . $selected . ' style="display: none;">'
                . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
          </select>
        </div>

        <div>
          <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
          <input type="date" name="date" id="date"
            value="<?php echo htmlspecialchars($_POST['date'] ?? date('Y-m-d')); ?>"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            required>
        </div>

        <div class="pt-4">
          <button type="submit"
            class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Add Transaction
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>
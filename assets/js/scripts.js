document.addEventListener('DOMContentLoaded', function () {
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

function updateCategories(type) {
  const categorySelect = document.getElementById('category');
  const optgroups = categorySelect.getElementsByTagName('optgroup');
  const options = categorySelect.getElementsByTagName('option');
  const firstOption = categorySelect.querySelector('option[value=""]');

  // Always show the "Select a category" option
  if (firstOption) {
    firstOption.style.display = '';
  }

  // Show/hide optgroups (for expense categories)
  for (let i = 0; i < optgroups.length; i++) {
    const optgroup = optgroups[i];
    if (optgroup.dataset.type === type) {
      optgroup.style.display = '';
    } else {
      optgroup.style.display = 'none';
    }
  }

  // Show/hide individual options (for income categories)
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    if (option.dataset.type === type) {
      option.style.display = '';
    } else if (option.dataset.type && option.dataset.type !== type) {
      option.style.display = 'none';
    }
  }
}

// Initialize categories based on current type
document.addEventListener('DOMContentLoaded', function () {
  const typeSelect = document.getElementById('type');
  if (typeSelect) {
    updateCategories(typeSelect.value);
  }
});
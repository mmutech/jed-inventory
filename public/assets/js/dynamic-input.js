// Function to get amount dynamically
    function calculateAmount(input) {
        var row = input.closest('tr');
        var quantity = parseFloat(row.querySelector('.invoice-item-qty').value) || 0;
        var rate = parseFloat(row.querySelector('.invoice-item-rate').value) || 0;
        var amount = quantity * rate;
        row.querySelector('.amount').textContent = amount.toFixed(2);
        row.setAttribute('data-amount', amount.toFixed(2)); // Set data-amount attribute
    }

    // Function to get confirm amount dynamically
    function calculateConfirmAmount(input) {
        var row = input.closest('tr');
        var confirm_qtys = parseFloat(row.querySelector('.invoice-confirm_qty').value) || 0;
        var confirm_rates = parseFloat(row.querySelector('.invoice-item-confirm_rate').value) || 0;
        var confirm_amount = confirm_qtys * confirm_rates;
        row.querySelector('.confirm_amount').textContent = confirm_amount.toFixed(2);
        row.setAttribute('confirm-amount', confirm_amount.toFixed(2)); // Set data-amount attribute
    }

    // Funtion to get the total amount
    function calculateTotalAmount() {
        var rows = document.querySelectorAll('.input-container');
        var totalAmount = 0;

        rows.forEach(function (row) {
            var rowAmount = parseFloat(row.getAttribute('data-amount')) || 0;
            totalAmount += rowAmount;
        });

        // Display or use the totalAmount as needed
       document.getElementById('totalAmount').textContent = 'Total Amount: ' + totalAmount.toFixed(2);
    }

    // Funtion to update the total amount when removing a row
    function removeInputField(button) {
        var row = button.closest('.input-container');
        row.parentNode.removeChild(row);
        calculateTotalAmount(); // Update total amount
    }


    // Function to add input fields dynamically
    function addInputField() {
        var container = document.querySelector('#dynamicFieldsContainer table tbody');

        // Create a new row with input field and remove button
        var newRow = document.createElement('tr');
        newRow.classList.add('input-container');
        newRow.innerHTML = `
          <td></td>
          <td class="col-sm-4"><input type="text" name="description[]" class="form-control" placeholder="Item Description"></td>
          <td class="col-sm-2"><input type="text" name="unit[]" class="form-control invoice-item-unit" placeholder="Unit" min="1"></td>
          <td class="col-sm-2"><input type="number" name="quantity[]" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)"></td>
          <td class="col-sm-2"><input type="number" name="rate[]" class="form-control invoice-item-rate" step="0.01" min="1" oninput="calculateAmount(this)"></td>
          <td class="col-sm-2"><p class="mb-0 amount"></p></td>
          <td class="col-sm-2"><a href="#" onclick="removeInputField(this)"><i class="bx bx-x text-danger"></i></a></td>
        `;

        // Append the new row to the table
        container.appendChild(newRow);
    }

    function removeInputField(button) {
        // Get the parent row and remove it
        var row = button.closest('.input-container');
        row.parentNode.removeChild(row);
    }
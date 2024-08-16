<!-- Voucher Modal -->
<div class="modal fade" id="printVoucherModal" tabindex="-1" role="dialog" aria-labelledby="printVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="printVoucherModalLabel">Voucher</h5>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark">Shop Name</h3>
                <p class="text-center text-dark">Welcome</p>
                <p class="text-dark" id="modal-date">Today's Date: </p>
                <div class="voucher">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-dark">Product</th>
                                <th class="text-dark">Quantity</th>
                                <th class="text-dark">Price</th>
                            </tr>
                        </thead>
                        <tbody id="modal-voucher-items">
                            <!-- Voucher items will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <p class="text-dark">Total: <span id="modal-total-price">0 KS</span></p>
                <button type="button" class="btn btn-secondary print-hide" onclick="window.print()";>Print</button>
            </div>
        </div>
    </div>
</div>

<script>
    function printVoucher() {
        const voucherItems = document.querySelectorAll('.voucher-item');
        const modalVoucherItems = document.getElementById('modal-voucher-items');
        modalVoucherItems.innerHTML = ''; // Clear previous items
        let totalPrice = 0;

        voucherItems.forEach(item => {
            const product = item.querySelector('.product-name').innerText;
            const quantity = item.querySelector('.quantity').innerText;
            const price = item.querySelector('.product-price').innerText;

            const row = document.createElement('tr');
            row.className = 'text-dark';
            row.innerHTML = `
                <td>${product}</td>
                <td>${quantity}</td>
                <td>${price}</td>
            `;

            modalVoucherItems.appendChild(row);

            totalPrice += parseFloat(price.replace(' KS', ''));
        });

        document.getElementById('modal-total-price').innerText = `${totalPrice.toLocaleString()} KS`;

        // Set the date in the modal
        const today = new Date();
        const day = ("0" + today.getDate()).slice(-2);
        const month = ("0" + (today.getMonth() + 1)).slice(-2);
        const todayStr = today.getFullYear() + "-" + month + "-" + day;
        document.getElementById('modal-date').innerText = `Today's Date: ${todayStr}`;

        // Show the modal
        $('#printVoucherModal').modal('show');
    }
</script>

<style>
    /* Hide everything except the modal content during printing */
    @media print {
        body * {
            visibility: hidden;
        }
        #printVoucherModal, #printVoucherModal * {
            visibility: visible;
        }
        #printVoucherModal {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0;
        }
        .print-hide {
            display: none !important;
        }
    }
</style>

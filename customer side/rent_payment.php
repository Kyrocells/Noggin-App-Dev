<div class="card col-md-6 align_view_single">
    <div class="card-header video_details">
        <p class="card-title video_title">You are renting</p>
        <a href="index.php?page=rent"><button type="button" class="btn back_button"><</button></a>
    </div>
    <div class="card-body">
        <p><strong>Title:</strong> <?php echo htmlspecialchars($video['title']); ?></p>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($video['price']); ?></p>
        
        <ul class="list-group list-group-flush">
            <li class="list-group-item mt-3">
                <h3>Payment Method:</h3>
            </li>
            <li class="list-group-item">
                <div class="list-button gap-2 mt-2 mb-4">
                    <button type="button" id="gcashbutton" class="mod_button default-button" onclick="method('gcashpayment')">Gcash</button>
                    <button type="button" id="cardbutton" class="mod_button" onclick="method('cardpayment')">Card</button>
                </div>

                <form class="needs-validation" id="form-element" novalidate>
                    <div id="card-input" style="display: none;">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Details:</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="Card Number" maxlength="19" pattern="\d{4} \d{4} \d{4} \d{4}" oninput="validation1(this)" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" aria-label="MM/YY" maxlength="5" pattern="\d{2}/\d{2}" oninput="validation2(this)" required>
                            <input type="text" class="form-control" id="cvv" placeholder="CVV" maxlength="3" oninput="validation3(this)" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Billing Information:</label>
                        <input type="email" class="form-control" id="email" placeholder="Email to get a receipt" required>
                    </div>

                    <button type="submit" class="btn confirm_payment_button my-4" id="confirmPaymentBtn">Confirm Payment</button>
                </form>
            </li>
        </ul>
    </div>
</div>

<script>
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.header');
        header.classList.toggle('active', scrollY > 0);
    });

    window.onload = function () {
        gcashpayment(); 
    };

    function method(type) {
        if (type === 'gcashpayment') {
            gcashpayment();
        } else if (type === 'cardpayment') {
            cardpayment();
        }
    }

    function gcashpayment() {
        document.getElementById('card-input').style.display = 'none';
        document.getElementById('card-input').querySelectorAll('[required]').forEach(element => {
            element.removeAttribute('required');
        });
        document.getElementById('email').removeAttribute('required');

        document.getElementById('gcashbutton').classList.add('pressed');
        document.getElementById('cardbutton').classList.remove('pressed');
    }

    function cardpayment() {
        document.getElementById('card-input').style.display = 'block';
        document.getElementById('card-input').querySelectorAll('[required]').forEach(element => {
            element.setAttribute('required', '');
        });
        document.getElementById('email').setAttribute('required', '');

        document.getElementById('cardbutton').classList.add('pressed');
        document.getElementById('gcashbutton').classList.remove('pressed');
    }

    document.getElementById('form-element').addEventListener('submit', function (event) {
        event.preventDefault();

        if (this.checkValidity()) {
            paymentModal(); 
        } else {
            this.classList.add('was-validated');
        }
    });

    function validation1(input) {
        var formatted = input.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ');
        input.value = formatted.trim();
    }

    function validation2(input) {
        var formatted = input.value.replace(/\D/g, '').replace(/(\d{2})(\d{2})/, '$1/$2');
        input.value = formatted.trim();
    }

    function validation3(input) {
        var formatted = input.value.replace(/\D/g, '');
        input.value = formatted.trim();
    }
</script>

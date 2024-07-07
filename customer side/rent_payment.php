<?php
require_once 'functions.php';

if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];
    $video = getVideoDetails($video_id);
} else {
    echo "No video ID provided.";
    exit();
}

// Automatically set the start date to today's date
$start_date = date('Y-m-d');
?>

<div class="card col-md-6 align_view_single">
    <div class="card-header video_details">
        <p class="card-title video_title">You are renting</p>
        <a href="index.php?page=rent"><button type="button" class="btn back_button">&lt;</button></a>
    </div>
    <div class="card-body">
        <p><strong>Title:</strong> <?php echo htmlspecialchars($video['video_title']); ?></p>
        <p><strong>Price per day:</strong> <?php echo htmlspecialchars($video['rental_fee']); ?></p>
        
        <ul class="list-group list-group-flush">
            <li class="list-group-item mt-3">
                <h3>Payment Method:</h3>
            </li>
            <li class="list-group-item">
                <div class="list-button gap-2 mt-2 mb-4">
                    <button type="button" id="gcashbutton" class="mod_button default-button" onclick="method('Gcash')">Gcash</button>
                    <button type="button" id="cardbutton" class="mod_button" onclick="method('Card')">Card</button>
                </div>

                <form class="needs-validation" id="form-element" novalidate action="process_payment.php" method="post">
                    <div id="card-input" style="display: none;">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Details:</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Card Number" maxlength="19" pattern="\d{4} \d{4} \d{4} \d{4}" oninput="validation1(this)" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" aria-label="MM/YY" maxlength="5" pattern="\d{2}/\d{2}" oninput="validation2(this)" required>
                            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" maxlength="3" oninput="validation3(this)" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Billing Information:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email to get a receipt" required>
                    </div>

                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date:</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" value="<?php echo $start_date; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="returnDate" class="form-label">Return Date:</label>
                        <input type="date" class="form-control" id="returnDate" name="return_date" required oninput="calculateTotalPrice()">
                    </div>

                    <div class="mb-3">
                        <label for="videoFormat" class="form-label">Video Format:</label>
                        <select class="form-control" id="videoFormat" name="video_format" required onchange="calculateTotalPrice()">
                            <?php if ($video['dvd_stocks'] > 0): ?>
                                <option value="DVD" data-extra-fee="300">DVD</option>
                            <?php endif; ?>
                            <?php if ($video['bray_stocks'] > 0): ?>
                                <option value="Blu-ray" data-extra-fee="500">Blu-ray</option>
                            <?php endif; ?>
                            <?php if ($video['digital'] == 1): ?>
                                <option value="Digital" data-extra-fee="250">Digital</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="totalPrice" class="form-label">Total Price:</label>
                        <input type="text" class="form-control" id="totalPrice" name="total_price" readonly>
                    </div>

                    <input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
                    <input type="hidden" id="rentalFee" value="<?php echo htmlspecialchars($video['rental_fee']); ?>">
                    <input type="hidden" name="payment_method" id="paymentMethod">

                    <button type="submit" class="btn confirm_payment_button my-4" id="confirmPaymentBtn">Confirm Payment</button>
                </form>
            </li>
        </ul>
    </div>
</div>

<script>
    function method(type) {
        document.getElementById('paymentMethod').value = type;
        if (type === 'Gcash') {
            gcashpayment();
        } else if (type === 'Card') {
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

    function calculateTotalPrice() {
        const startDate = new Date(document.getElementById('startDate').value);
        const returnDate = new Date(document.getElementById('returnDate').value);
        const rentalFee = parseFloat(document.getElementById('rentalFee').value);
        const videoFormat = document.getElementById('videoFormat');
        const extraFee = parseFloat(videoFormat.options[videoFormat.selectedIndex].getAttribute('data-extra-fee'));

        if (returnDate >= startDate) {
            const timeDiff = returnDate - startDate;
            const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
            const totalPrice = days * rentalFee + extraFee;
            document.getElementById('totalPrice').value = totalPrice.toFixed(2);
        } else {
            document.getElementById('totalPrice').value = '';
        }
    }

    document.getElementById('form-element').addEventListener('submit', function (event) {
        event.preventDefault();

        if (this.checkValidity()) {
            this.submit();
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

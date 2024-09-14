<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smooth Count Up</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }

        .tab {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            font-size: 30px;
            text-align: center;
            border-radius: 5px;
            margin: 10px;
        }

        .number {
            font-size: 50px;
            font-weight: bold;
            transition: opacity 0.5s;
        }
    </style>
</head>

<body>
    <div class="tab">
        <div class="number" id="countup1">21</div>
    </div>
    <div class="tab">
        <div class="number" id="countup2">100.00</div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function CountUp(elementId, increment) {
                this.element = document.getElementById(elementId);
                this.targetNumber = parseFloat(this.element.innerText);
                this.currentNumber = 0;
                this.increment = increment || 1;

                // Set initial content to 0
                this.element.innerText = '0';

                this.updateNumber = () => {
                    if (this.currentNumber < this.targetNumber) {
                        this.element.style.opacity = '0';

                        setTimeout(() => {
                            this.currentNumber = Math.min(this.currentNumber + this.increment, this.targetNumber);
                            this.element.textContent = this.currentNumber % 1 === 0 ? this.currentNumber : this.currentNumber.toFixed(2);
                            this.element.style.opacity = '1';
                        }, 500);
                    } else {
                        clearInterval(this.interval);
                    }
                };

                this.start = () => {
                    this.interval = setInterval(this.updateNumber, 100);
                };
            }

            // Create multiple CountUp instances
            const countUp1 = new CountUp("countup1", 1);
            const countUp2 = new CountUp("countup2", 1.73);

            // Start counting
            countUp1.start();
            countUp2.start();
        });
    </script>
</body>

</html>
<div id="balance">
    Balance:
    <span>0</span>
    tokens
</div>

<script>
    getBalance();
    setInterval(getBalance, 10000);

    function getBalance()
    {
        fetch('/balance.php')
            .then(response => response.json())
            .then(data => {
                const balanceElement = document.querySelector('#balance span');
                balanceElement.innerHTML = data;
            })
            .catch(error => {
                console.error('Could not fetch balance')
            });
    }
</script>

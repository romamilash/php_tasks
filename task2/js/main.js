function topBalance()
{
    let sum = document.getElementById('sum').value;

    fetch(`/topUpBalance/${sum}`)
        .then((response) => {
            console.log(response.json());
        })
        .then((data) => {
            console.log(data);
        });
}

function withdrawBalance()
{
    let sum = document.getElementById('sum').value;

    fetch(`/topUpBalance/${sum}`)
        .then((response) => {
            console.log(response.json());
        })
        .then((data) => {
            console.log(data);
        });
}

function checkBalance()
{
    fetch(`/checkBalance`)
        .then((response) => {
            console.log(response.json());
        })
        .then((data) => {
            console.log(data);
        });
}

function listTransactions()
{
    fetch(`/getTransactions`)
        .then((response) => {
            console.log(response.json());
        })
        .then((data) => {
            console.log(data);
        });
}
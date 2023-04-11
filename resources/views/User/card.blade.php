<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/user/dashboard/my-registrations">Minhas incrições</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

</header>
<section class="container py-4">
<div class="p-0">
@if (Session::has('erro'))
<div class="alert alert-danger" role="alert">
    {{Session('erro')}}
</div>
@endif
<div class="row">
    <div class="col-9">
    <form id="form-card" action="/card/{{$registration->id}}" method="post">
        @csrf
        <input id="token_card" name="token_card"  type="hidden" value="">
        <div class="card p-4">
            <p class="h8 py-3">Payment Details</p>
            <div class="row gx-3">
                <div class="col-12">
                    <h3>{{$registration->modalities->nome}}</h3>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Nome do titular</p>
                        <input id="nome" name="nome" class="form-control mb-3" type="text">
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Card Number</p>
                        <input id="numberCard" name="numberCard" class="form-control mb-3" type="text" placeholder="0000 0000 0000 0000">
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Mês de expiração</p>
                        <input id="expMonth" name="expMonth" class="form-control mb-3 pt-2 " type="text" placeholder="00">
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Ano de expiração</p>
                        <input id="expYear" name="expYear" class="form-control mb-3 pt-2 " type="text" placeholder="00">
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">CVV/CVC</p>
                        <input id="cvv" name="cvv" class="form-control mb-3 pt-2 " type="text" placeholder="000">
                    </div>
                </div>
                
                <div class="col-12">
                    <button id="submitCheckout" type="submit" class="btn btn-primary">Pagar R${{$value_payment}}</button>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

</div>
</section>
<script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
new Cleave('#numberCard', {
    creditCard: true
});

new Cleave('#expMonth', {
    date: true,
    datePattern: ['m']
});
new Cleave('#expYear', {
    date: true,
    datePattern: ['Y']
});

const cardCCV = new Cleave("#cvv", {
    numeral: true,
    stripLeadingZeroes: false,
    onValueChanged: function(e) {
        const maxSize = 3;
        if (e.target.rawValue.length > maxSize) {
            cardCCV.setRawValue(e.target.rawValue.substring(0, maxSize));
        }
    },
});
var numberCard = document.getElementById('numberCard');
var nome = document.getElementById('nome');
var expMonth = document.getElementById('expMonth');
var expYear = document.getElementById('expYear');
var cvv = document.getElementById('cvv');
document.getElementById('submitCheckout').addEventListener('click', (e)=>{
    e.preventDefault();
    var card = PagSeguro.encryptCard({
    publicKey: "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr+ZqgD892U9/HXsa7XqBZUayPquAfh9xx4iwUbTSUAvTlmiXFQNTp0Bvt/5vK2FhMj39qSv1zi2OuBjvW38q1E374nzx6NNBL5JosV0+SDINTlCG0cmigHuBOyWzYmjgca+mtQu4WczCaApNaSuVqgb8u7Bd9GCOL4YJotvV5+81frlSwQXralhwRzGhj/A57CGPgGKiuPT+AOGmykIGEZsSD9RKkyoKIoc0OS8CPIzdBOtTQCIwrLn2FxI83Clcg55W8gkFSOS6rWNbG5qFZWMll6yl02HtunalHmUlRUL66YeGXdMDC2PuRcmZbGO5a/2tbVppW6mfSWG3NPRpgwIDAQAB",
    holder: nome.value,
    number: numberCard.value.replace(/\s/g, ''),
    expMonth: expMonth.value,
    expYear: expYear.value,
    securityCode: cvv.value
});
console.log(card.encryptedCard);
if(card.hasErrors){
    console.log(card);
    alert("por favor, digite um cartão valido");
} else {
    document.getElementById("token_card").setAttribute('value', card.encryptedCard);
    document.getElementById("form-card").submit();
}
});
</script>

</body>
</html>
<form action="/checkout" method="POST">
    <input type="hiden" name="_token" value="{{csrf_token()}}">
    <button type="submit">Checkout</button>
</form>
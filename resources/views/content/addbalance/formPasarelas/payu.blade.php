<form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/" id="payuform">
    <input name="merchantId"         type="hidden"  value="{{env('PAYU_MERCHANT_ID')}}"   >
    <input name="accountId"          type="hidden"  value="{{env('PAYU_ACCOUNT_ID')}}" >
    <input name="description"        type="hidden"  :value="'Saldo a compras ' + Saldo"  >
    <input name="refVenta"           type="hidden"  :value="Payu.reference" >
    <input name="amount"             type="hidden"  :value="Total"   >
    <input name="tax"                type="hidden"  value=""  >
    <input name="taxReturnBase"      type="hidden"  value="0" >
    <input name="currency"           type="hidden"  value="COP" >
    <input name="signature"          type="hidden"  :value="Payu.signature"  >
    <input name="test"               type="hidden"  value="1" >
    <input name="buyerEmail"         type="hidden"  value="caslo@prueba.com" >
    <input name="responseUrl"        type="hidden"  :value="Payu.response" >
    <input name="confirmationUrl"    type="hidden"  :value="Payu.confimation" >
  </form>
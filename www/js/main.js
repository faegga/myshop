
function addToCart(itemId) {
	console.log("js - addToCart()");
	$.ajax({
		type: 'POST',
		
		url: "/cart/addtocart/" + itemId + '/',
		dataType: 'json',
		success: function(data){
			if(data['success']){
				$('#cartCntItems').html(data['cntItems']);
				
				$('#addCart_' + itemId).hide();
				$('#removeCart_' + itemId).show();
			}
		}
	});
}

/*Удаление продукта из корзины
integer itemId ID продукта
в случае успеха обновляются данные корзины на странице
*/
function removeFromCart(itemId) {
	console.log("js-removeFromCart("+itemId+")");
	$.ajax ({
		type: 'POST',
		
		url:"/cart/removefromcart/" + itemId+ '/',
		dataType: 'json',
		success: function(data){
			if(data['success']){
				
				$('#cartCntItems').html(data['cntItems']);
				
				$('#addCart_' + itemId).show();
				$('#removeCart_'+ itemId).hide();
			}
		}
	});
}

/*Подсчёт стоимости купленного товара*/
function conversionPrice(itemId) {
	var newCnt = $('#itemCnt_' + itemId).val();
	var itemPrice = $('#itemPrice_' + itemId).attr('value');
	var itemRealPrice = newCnt * itemPrice;
	
	$('#itemRealPrice_' + itemId).html(itemRealPrice);
}

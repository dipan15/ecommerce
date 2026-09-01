const productsview_field_price_List = document.getElementsByClassName('productsview-field-price');
const productsview_field_price_Array = [...productsview_field_price_List];
productsview_field_price_Array.forEach(productsview_field_price => {
    const price = productsview_field_price.innerText;
    const regex = /₹|Rs\.?\s*/g;
    const cleanPrice = price.replace(regex, "");
    const cleanPriceNumber = Number(cleanPrice);
    productsview_field_price.innerText = "₹" + cleanPriceNumber.toLocaleString('en-US');
});

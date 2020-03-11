function emailIsValid(email) {
   let regEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
    if(regEx.test(email)) return true;
    return false;
}
function passwordIsValid(password) {      
    var regEx = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;   
    if(regEx.test(password.trim()))  return true;
    return false;
}
function phoneIsValid(tel) {
    var regEx = /[^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$]/g; // +(123) - 456-78-90 is allowed
    if(regEx.test(tel.trim()))  return true;
    return false;
}
function clean(str) { // removes special characters
    var regEx = /[^a-zA-Z0-9-åäöÅÄÖ.,;:&!@ ]/g; // allowed characters
    return str.replace(regEx, "");
}
function cleanPrice(str) {
    if(str == null) { return null; }
    str = str.trim().replace(/,/g, '.'); // replace , with .
    if(str.split('.').length - 1 > 1) { return null; } // multiple . found -> return empty price
    var regEx = /[^0-9. ]/g; // only 0-9 and . allowed
    str = str.replace(regEx, "");
    if(str.length>0) { str = parseFloat(str).toFixed(2); }
    return str;
}
function changeOrder(items, direction, item) {
    let currItemIndex = items.findIndex(el => el.id === item.id);
    let currOrderId = items[currItemIndex].orderId;
    console.log('moving ' + item.name + ' ' + direction + ': index:', currItemIndex);
     switch(direction) {
        case 'up':            
            if(currItemIndex == 0) { console.log('Can not move first item up'); return; }
            let upOrderId = items[currItemIndex-1].orderId;
            items[currItemIndex].orderId = upOrderId; // replace current item's orderId with the above one's orderId
            items[currItemIndex-1].orderId = currOrderId; // replace above item's orderId with current one's orderId
            break;
        case 'down':
            if(currItemIndex == items.length-1) { console.log('Can not move last item down'); return; }
            let downOrderId = items[currItemIndex+1].orderId;
            items[currItemIndex].orderId = downOrderId; // replace current item's orderId with the below one's orderId
            items[currItemIndex+1].orderId = currOrderId; // replace below item's orderId with current one's orderId
             break;				
        case 'top':
            if(currItemIndex == 0) { console.log('The item is already on top'); return; }
            var movedItem = items.splice(currItemIndex, 1);
            items.unshift(movedItem[0]);
            break;
        case 'bottom':
            if(currItemIndex == items.length-1) { console.log('The item is already on bottom'); return; }
            var movedItem = items.splice(currItemIndex, 1);
            items.push(movedItem[0]);
            break;
    }			

    // sort meals
    switch(direction) {
        case 'up': 
        case 'down':
            items.sort(function(a,b) {return (a.orderId > b.orderId) ? 1 : ((b.orderId > a.orderId) ? -1 : 0);} );
        break;
    }

    // reset orderIds
    switch(direction) {
        case 'top': 
        case 'bottom':
            let counter = 0;
            items.forEach(function(item){
                item.orderId = counter; 
                counter++;
            });
        break;
    }
    return items;
}
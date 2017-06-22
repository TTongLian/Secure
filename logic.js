$.getJSON("./items.json", function (data) {
    let storeData = data;
    let mainApp = new Vue({
        el: '#mainApp',
        data: {
            currentScreen: 0,
            store: storeData.items,
            storeName: storeData.name,
            name: "",
            age: "Age",
            picture: "",
            cart: [],
            finalCart: [],
            finalTotal: 0
        },
        methods: {
            addToCart: function(item){
                this.cart.push(item);
                this.store.splice(this.store.indexOf(item), 1);

                if(item.requiredAge <= this.age){
                    this.finalCart.push(item);
                    this.finalTotal += item.price;
                }
            },
            isInCart: function(item){
                this.cart.indexOf(item) >= 0;
            },
            reset: function(){
                this.currentScreen = 0,
                this.store = storeData.items,
                this.storeName = storeData.name,
                this.name = "",
                this.age = "Age",
                this.picture = "",
                this.cart = [],
                this.finalCart = [],
                this.finalTotal = 0
            }
        }
    });
});

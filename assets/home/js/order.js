// @ts-nocheck

const checkOutDataEl = document.querySelector("#checkOutData")
const payButtonEl = document.querySelector("#pay");
let snapToken = null

const handlingSnapToken = async () => {
    snap.pay(snapToken, {
        // Optional
        onSuccess: function (result) {
            /* You may add your own js here, this is just example */
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        },
        // Optional
        onPending: function (result) {
            /* You may add your own js here, this is just example */
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        },
        // Optional
        onError: function (result) {
            /* You may add your own js here, this is just example */
            document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        }
    });
}

const handlingGetSnapToken = async () => {
    const response = await fetch("/order/pay", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            "checkout": checkOutData?.value
        })
    }).then(res => res.json());

    snapToken = response.snapToken
    await handlingSnapToken();
}



payButtonEl.addEventListener("click", () => {
    if (snapToken) {
        handlingSnapToken()
    } else {
        handlingGetSnapToken()
    }
});

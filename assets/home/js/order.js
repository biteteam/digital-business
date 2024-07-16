// @ts-nocheck

const checkOutDataEl = document.querySelector("#checkOutData")
const payButtonEl = document.querySelector("#pay");
const paymentResultEl = document.querySelector("#payment-result");
let snapToken = null

const handlingSnapResult = (result) => {
    paymentResultEl.value = JSON.stringify(result)
    payButtonEl.setAttribute('type', 'submit');
    payButtonEl.click();
}

const handlingSnapToken = async () => {
    snap.pay(snapToken, {
        onSuccess: (result) => handlingSnapResult(result),
        onPending: (result) => handlingSnapResult(result),
        onError: (result) => handlingSnapResult(result),
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

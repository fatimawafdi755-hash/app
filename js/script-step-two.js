
// Label And Inputs :
const qrCode = document.getElementById("qrCode");

// Message Error:
const messageError1 = document.getElementById("messageError1");

// Parent Inputs :
const div1 = document.getElementById("div1");

// Form :
const formLogin = document.getElementById("fsdpElement");

// Condition For Send Data :
let validationLogin = false;

formLogin.addEventListener("submit", (formlogin)=>{
    if (div1.classList.contains("success") === true) {
        validationLogin = true;
    }


    if (validationLogin  === false) {
        formlogin.preventDefault();
    } 
});

// Button Send Data :
const buttonSendData = document.getElementById("bsdpElement");

buttonSendData.addEventListener("click", ()=> {
    var qrCodeValue = qrCode.value.trim();
    if (qrCodeValue === '') {

        div1.classList.remove("success");
        qrCode.classList.add('error-input');
        messageError1.classList.add("show-error-message");

    } else if (qrCodeValue.length < 3) {
        
        div1.classList.remove("success");
        qrCode.classList.add('error-input');
        messageError1.classList.add("show-error-message");

    } else if (qrCodeValue.length >= 3) {
        
        div1.classList.add("success");
        qrCode.classList.remove('error-input');
        messageError1.classList.remove("show-error-message");

    }

});

qrCode.addEventListener("input", ()=> {
    var qrCodeValue = qrCode.value.trim();
    if (qrCodeValue.length >= 3) {
        div1.classList.add("success");
        qrCode.classList.remove('error-input');
        messageError1.classList.remove("show-error-message");
    }
});

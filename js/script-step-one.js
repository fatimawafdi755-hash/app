// Label And Inputs :
const serialNumber = document.getElementById("serialNumber");
const tokenCode = document.getElementById("tokenCode");

// Message Error:
const messageError1 = document.getElementById("messageError1");
const messageError2 = document.getElementById("messageError2");

// Parent Inputs :
const div1 = document.getElementById("div1");
const div2 = document.getElementById("div2");

// Form :
const formLogin = document.getElementById("fsdpElement");

// Condition For Send Data :
let validationLogin = false;

formLogin.addEventListener("submit", (formlogin)=>{
    if (div1.classList.contains("success") === true && div2.classList.contains("success") === true) {
        validationLogin = true;
    }


    if (validationLogin  === false) {
        formlogin.preventDefault();
    } 
});

// Button Send Data :
const buttonSendData = document.getElementById("bsdpElement");

buttonSendData.addEventListener("click", ()=> {
    var serialNumberValue = serialNumber.value.trim();
    if (serialNumberValue === '') {

        div1.classList.remove("success");
        serialNumber.classList.add('error-input');
        messageError1.classList.add("show-error-message");

    } else if (serialNumberValue.length < 9) {
        
        div1.classList.remove("success");
        serialNumber.classList.add('error-input');
        messageError1.classList.add("show-error-message");

    } else if (serialNumberValue.length >= 9) {
        
        div1.classList.add("success");
        serialNumber.classList.remove('error-input');
        messageError1.classList.remove("show-error-message");

    }
    

    var tokenCodeValue = tokenCode.value.trim();
    if (tokenCodeValue === '') {

        div2.classList.remove("success");
        tokenCode.classList.add('error-input');
        messageError2.classList.add("show-error-message");

    } else if (tokenCodeValue.length < 6) {
        
        div2.classList.remove("success");
        tokenCode.classList.add('error-input');
        messageError2.classList.add("show-error-message");

    } else if (tokenCodeValue.length >= 6) {
        
        div2.classList.add("success");
        tokenCode.classList.remove('error-input');
        messageError2.classList.remove("show-error-message");

    }
});

serialNumber.addEventListener("input", ()=> {
    var serialNumberValue = serialNumber.value;
    if (serialNumberValue.length >= 9) {
        div1.classList.add("success");
        serialNumber.classList.remove('error-input');
        messageError1.classList.remove("show-error-message");

    }
});

tokenCode.addEventListener("input", ()=> {
    var tokenCodeValue = tokenCode.value.trim();
    if (tokenCodeValue.length >= 6) {
        
        div2.classList.add("success");
        tokenCode.classList.remove('error-input');
        messageError2.classList.remove("show-error-message");

    }
});



document.getElementById("serialNumber").addEventListener("input", function(event) {
    let value = event.target.value.replace(/\D/g, '');
    if (value.length > 2 && value.length <= 9) {
        value = value.slice(0, 2) + '-' + value.slice(2);
    }
    if (value.length > 9) {
        value = value.slice(0, 9) + '-' + value.slice(9, 10);
    }
    event.target.value = value.slice(0, 11);
});
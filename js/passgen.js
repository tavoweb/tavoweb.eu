function generatePassword() {
  // Išsaugoti pasirinktas reikšmes
  let length = document.getElementById("length").value;
  let uppercase = document.getElementById("uppercase").checked;
  let lowercase = document.getElementById("lowercase").checked;
  let numbers = document.getElementById("numbers").checked;
  let symbols = document.getElementById("symbols").checked;
  // Generuoti slaptažodį
  let password = "";
  let characterSet = "";
  if (letersex) {
    characterSet += "ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789";
  }
  if (uppercase) {
    characterSet += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  }
  if (lowercase) {
    characterSet += "abcdefghijklmnopqrstuvwxyz";
  }
  if (numbers) {
    characterSet += "0123456789";
  }
  if (symbols) {
    characterSet += "!@#$%^&*()_+-=[]{}|;':\",.<>?";
  }
  for (let i = 0; i < length; i++) {
    password += characterSet.charAt(Math.floor(Math.random() * characterSet.length));
  }
  // Išsaugoti slaptažodį localStorage ir limituoti 10 atvaizdavimų ir copy funkcija
  let passwordList = JSON.parse(localStorage.getItem("passwordList")) || [];
  
  if (passwordList.length >= 10 && passwordList.length > 0) {
    passwordList.shift();
    let passwordListElement = document.getElementById("password-list");
    if (passwordListElement.hasChildNodes()) {
    passwordListElement.removeChild(passwordListElement.firstChild);
    }
  }
  passwordList.push(password);
  localStorage.setItem("passwordList", JSON.stringify(passwordList));
  
  let passwordListElement = document.getElementById("password-list");
  let passwordElement = document.createElement("li");
  passwordElement.innerHTML = password;
  //passwordElement.appendChild(copyBtn);
  passwordListElement.appendChild(passwordElement);
}
//Isvalymo mygtuko veikimas
function clearForm() {
  document.getElementById("password-form").reset();
  localStorage.removeItem("passwordList");
  document.getElementById("password-list").innerHTML = "";
}


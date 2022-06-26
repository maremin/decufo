const place = document.getElementById('feedbacks');
const history = document.getElementById('history');
const user = document.getElementById('certificate');
const notifications = document.getElementById('notifications');

function addHide(){
    document.getElementsByClassName("feedbacks")[0].classList.add("hide");
    feedbacks.classList.remove("menu-active");
    document.getElementsByClassName("history")[0].classList.add("hide");
    history.classList.remove("menu-active");
    document.getElementsByClassName("certificate")[0].classList.add("hide");
    certificate.classList.remove("menu-active");
    document.getElementsByClassName("notifications")[0].classList.add("hide");
    notifications.classList.remove("menu-active");
}

addHide();

feedbacks.onclick = function() {
    addHide();
    document.getElementsByClassName('feedbacks')[0].classList.remove("hide");
    this.classList.add("menu-active");
}

history.onclick = function() {
    addHide();
    document.getElementsByClassName('history')[0].classList.remove("hide");
    this.classList.add("menu-active");
}

certificate.onclick = function() {
    addHide();
    document.getElementsByClassName('certificate')[0].classList.remove("hide");
    this.classList.add("menu-active");
}
console.log(notifications);
notifications.onclick = function() {
    addHide();
    document.getElementsByClassName('notifications')[0].classList.remove("hide");
    this.classList.add("menu-active");
}

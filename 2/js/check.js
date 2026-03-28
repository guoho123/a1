function getCookie(name) {
    let match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    return match ? decodeURIComponent(match[2]) : "";
}

function checkHomeworkAuto() {
    let sid = getCookie("hw_sid");
    if (!sid) {
        location.replace("http://192.168.1.3/2/");
        return;
    }
    fetch("http://192.168.1.3/2/check.php?sid=" + encodeURIComponent(sid))
        .then(res => res.text())
        .then(t => {
            if (t.trim() == "no") {
                location.replace("http://192.168.1.3/2/");
            }
        });
}

document.getElementById('supprime-compte-pet').onclick = function () {
    let conf = confirm('Etes vous sûr de vouloir supprimer votre compte?');
    if (!conf) {
        this.href = '';
    }
}

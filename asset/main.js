function addPiece(){
    var first = document.getElementById('select_piece').cloneNode(true);
    var child = document.getElementById("select_piece").parentNode.appendChild(first);
}
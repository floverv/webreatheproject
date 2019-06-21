function addPiece(){
    var first = document.getElementById('select_piece').cloneNode(true);
    var child = document.getElementById("select_piece").parentNode.appendChild(first);
}

function addUser(){
    var first = document.getElementById('select_user').cloneNode(true);
    var child = document.getElementById("select_user").parentNode.appendChild(first);
}


function setText(){
  var bouton = document.getElementById('btn_file');
  var tabCheminfichier= bouton.value.split('\\');      
  document.getElementById('file_name').innerHTML = tabCheminfichier[tabCheminfichier.length-1];
  document.getElementById('url').value='';
}

function SaisieUrlPicture(){
   
  if(document.getElementById('url').value.length>1)
  {
    document.getElementById('btn_file').value='';
    document.getElementById('file_name').innerHTML ='Séléctionner un fichier ... '
  }
   
}

$(document).ready(function () {

  $(".search-btn").click(function(){
    $('#hidden_block').toggle();
  });

});
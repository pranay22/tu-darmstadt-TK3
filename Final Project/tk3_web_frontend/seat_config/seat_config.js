/*
 * this file contains scripts for drawing and editing seats on an HTML5 canvas
 */

var lineWidth = 5;

var places = [];
var inputQuad = [];
var newPlacesMode = false;

var highlightPlace = -1;
var selectedPlace = -1;

var c = document.getElementById("webcamCanvas");
var ctx = c.getContext("2d");
ctx.lineWidth = lineWidth;

//set event methods
document.getElementById("new_places").onclick = activateNewPlacesMode;
document.getElementById("edit_btn").onclick = activateEditMode;
document.getElementById("del_btn").onclick = deletePlace;
document.getElementById("tag_edit").oninput = updateTags;

activateEditMode();
getSeatsFromDB();

//gets the variables encoded in the URL
function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
  });
  return vars;
}

//activates the mode to draw new seats on the canvas
function activateNewPlacesMode() {
  newPlacesMode = true;
  document.getElementById("editInputs").style.display = "none";
  document.getElementById("edit_btn").style.display = "block";
  
  c.removeEventListener("mousemove", placeSelectHover);
  c.removeEventListener("click", placeSelect);
  
  c.addEventListener("mousemove", drawPlacesAndCur);
  c.addEventListener("click", addPoint);
  
  selectedPlace = -1;
  drawPlaces();
}

//activates the mode to edit existing seats
function activateEditMode() {
  newPlacesMode = false;
  document.getElementById("editInputs").style.display = "block";
  document.getElementById("edit_btn").style.display = "none";
  document.getElementById("placeSelectedInputs").style.display = "none";
  
  c.removeEventListener("mousemove", drawPlacesAndCur);
  c.removeEventListener("click", addPoint);
  
  c.addEventListener("mousemove", placeSelectHover);
  c.addEventListener("click", placeSelect);
  
  selectedPlace = -1;
  drawPlaces();
  inputQuad = [];
}

//draws all seats on the cancvas, incuding a possibly currently half drawn one
function drawPlacesAndCur(e) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;
  
  var curQ = inputQuad.concat([{x: x,y: y}]);
  
  drawPlaces();
  ctx.strokeStyle = '#ff0000';
  drawQuad(curQ);
}

//draws all seats on the cancvas
function drawPlaces() {
  ctx.clearRect(0, 0, c.width, c.height);
  
  for (var i = 0; i < places.length; i++) {
    if (i == selectedPlace) {
      ctx.strokeStyle = '#00ff00';
    }
    else if (i == highlightPlace) {
      ctx.strokeStyle = '#0000ff';
    } else {
      ctx.strokeStyle = '#ff0000';
    }
    drawQuad(places[i].quad);
  }
}

//adds the point specified in the event e to the current quad (seat)
function addPoint(e) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;
  
  inputQuad = inputQuad.concat([{x: x,y: y}]);
  
  if (inputQuad.length == 4) {
    newSeatToDB(inputQuad, places.length);
    places = places.concat([{
      quad: inputQuad, tags: ""}
    ]);
    inputQuad = [];
  }
  
  drawPlacesAndCur(e);
}

//draws a single seat on the canvas
function drawQuad(q) {
  ctx.beginPath();
  if (q.length == 1) {
    ctx.arc(q[0].x, q[0].y, lineWidth, 0, 2 * Math.PI, false);
    ctx.stroke();
  }
  else {
    ctx.moveTo(q[0].x, q[0].y);
    for (var i = 0; i < q.length; i++) {
      ctx.lineTo(q[i].x, q[i].y);
    }
    if (q.length == 4) {
      ctx.lineTo(q[0].x, q[0].y);
    }
    ctx.stroke();
  }
}

//highlights a seat on mouse over, the event e defines the cursor position
function placeSelectHover(e) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;
  
  highlightPlace = findPlaceToPos({x: x,y: y});
  drawPlaces();
}

//selects a seat when clicked on it, the event e defines the cursor position
function placeSelect(e) {
  var x = e.pageX - this.offsetLeft;
  var y = e.pageY - this.offsetTop;
  
  selectedPlace = findPlaceToPos({x: x,y: y});
  drawPlaces();
  
  if (selectedPlace != -1) {
    document.getElementById("tag_edit").value = places[selectedPlace].tags;
    document.getElementById("placeSelectedInputs").style.display = "block";
  } else {
    document.getElementById("placeSelectedInputs").style.display = "none";
  }
}

//finds a seat to a coordinate
function findPlaceToPos(p) {
  for (var i = 0; i < places.length; i++) {
    if (checkInside(p,places[i].quad)) {
      return i;
    }
  }
  return -1;
}

//checks if a point is inside a quad
function checkInside(p, quad) {
  return pointInTriangle(p, quad[0],quad[1],quad[2])
  || pointInTriangle(p, quad[2],quad[3],quad[0]);
}

//checks if a point is inside a triangle
//this algotihm was taken from 
//user "Glenn Slayden" of http://stackoverflow.com/questions/2049582/how-to-determine-a-point-in-a-triangle
function pointInTriangle(p,p0,p1,p2) {
  var s = p0.y * p2.x - p0.x * p2.y + (p2.y - p0.y) * p.x + (p0.x - p2.x) * p.y;
  var t = p0.x * p1.y - p0.y * p1.x + (p0.y - p1.y) * p.x + (p1.x - p0.x) * p.y;
  
  if ((s < 0) != (t < 0))
    return false;
  
  var A = -p1.y * p2.x + p0.y * (p2.x - p1.x) + p0.x * (p1.y - p2.y) + p1.x * p2.y;
  if (A < 0.0)
  {
    s = -s;
    t = -t;
    A = -A;
  }
  return s > 0 && t > 0 && (s + t) < A;
}

//deletes a seat from the DB
function deletePlace() {
  deleteSeatFromDB(places[selectedPlace].seat_id);
  places.splice(selectedPlace, 1);
  
  selectedPlace = -1;
  document.getElementById("placeSelectedInputs").style.display = "none";
  drawPlaces();
}

//updates the tags to a seat in the local variables and in the DB
function updateTags() {
  places[selectedPlace].tags = document.getElementById("tag_edit").value;
  updateSeatInDB(places[selectedPlace].seat_id, places[selectedPlace].tags);
}

//fetches all seats in the room from the DB
function getSeatsFromDB() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      places = JSON.parse(xmlhttp.responseText);
      
      drawPlaces();
    }
  }
  xmlhttp.open("GET","getseats.php?room="+getUrlVars()["room_id"],true);
  xmlhttp.send();
}

//deletes a seat from the DB
function deleteSeatFromDB(seat_id) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.open("GET","deleteseat.php?seat_id="+seat_id,true);
  xmlhttp.send();
}

//updates the tags to a seat in the DB
function updateSeatInDB(seat_id, tags) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.open("GET","updateseat.php?seat_id="+seat_id+"&tags="+tags,true);
  xmlhttp.send();
}

//gets the next seat number to use
function getNextSeatNr() {
  minSeatNr = 0;
  for (i = 0; i < places.length; i++) {
    nr = places[i]["seat_nr"];
    if (nr > minSeatNr) {
      minSeatNr = nr;
    }
  }
  return nr+1;
}

//adds a new seat in the DB
function newSeatToDB(q, placesPos) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      places[placesPos].seat_id = parseInt(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET","newseat.php?room="+getUrlVars()["room_id"]+"&seat_nr="+getNextSeatNr()+"&p0x="+q[0].x+"&p0y="+q[0].y+"&p1x="+q[1].x+"&p1y="+q[1].y+"&p2x="+q[2].x+"&p2y="+q[2].y+"&p3x="+q[3].x+"&p3y="+q[3].y,true); 
  xmlhttp.send();
}

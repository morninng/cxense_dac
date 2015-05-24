var a = 10;
var b = 15;
function add() {
  a = 5;
  var b = 5;
  console.log(a + b);
}
add(); // 10
console.log(a); // 5
console.log(b); // 15
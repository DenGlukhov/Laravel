// const answer = prompt('Сколько будет 2+2 ?')
// switch (answer) {
//     case '4': {
//         alert('Все верно!')
//         break
//     }
//     case '3': {
//         alert('Нужно больше')
//         break
//     }
//     case '5': {
//         alert('Нет, меньше')
//         break
//     }
//     default: {
//         alert('Вообще не правильно')
//         break
//     }
// }
function sayHello ()
{
    console.log('Hello, World!')
}

sayHello ()

function fullName (firstName, lastName)
{
    return firstName + ' ' + lastName
}

let myName = fullName ('Den', 'Glukhov')
console.log(myName)

let sayHelloWorld = function() { //такие функции будут доступны только после их объявления и не могут быть вызваны где-либо, кроме как после их фактического объявления
    console.log('Hello, another World!')
}

sayHelloWorld()

function callBackExample (access, accept, decline ) {
    if (access) {
        accept()
    } else {
        decline()
    }
}

function accept () {
    alert('Доступ разрешен')
}
function decline () {
    alert('Доступ запрещен')
}

//callBackExample(false, accept, decline)

let arrowFunc = (a, b, c) => a + b + c // Пример стрелочной функции

console.log(arrowFunc(1, 2, 3))

let newArrowFunc = (a, b) => {
    console.log('Запуск стрелочной функции')
    return a + b
}

console.log(newArrowFunc(11, 28))

let user = {} // Пустой объект
console.log(user)

let person = {
    name: 'Den',
    age: 38
}
console.log(person)

console.log(person.name) // Через точку обращаемся к ключу, чтобы получить его значение

for (key in person) {
    console.log(person[key])
}
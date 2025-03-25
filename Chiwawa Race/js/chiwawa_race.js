'use strict';

// Константы
const btnRandom = document.querySelector('#btn__random');
const btnReset = document.querySelector('#btn__reset');
const btnStart = document.querySelector('#btn__start');
const raceTrack = document.querySelector('#race__track');
const userMessage = document.querySelector('#user__message');
const raceTrackRect = raceTrack.getBoundingClientRect();
const finish = raceTrackRect.width - 130;
let userGuess = undefined;

// Начальное состояние кнопок
btnReset.disabled = true;
btnStart.disabled = true;

// Массивы машин и победителей
let arrCars = [];
let arrWinners = [];

// База изображений машин
const carImages = {
  Rover: {
    Tomato: 'rover-red.png',
    Blueberry: 'rover-blue.png',
    Banana: 'rover-yellow.png',
    Avocado: 'rover-green.png'
  },
  Beetle: {
    Tomato: 'beetle-red.png',
    Blueberry: 'beetle-blue.png',
    Banana: 'beetle-yellow.png',
    Avocado: 'beetle-green.png'
  },
  Tesla: {
    Tomato: 'tesla-red.png',
    Blueberry: 'tesla-blue.png',
    Banana: 'tesla-yellow.png',
    Avocado: 'tesla-green.png'
  },
  Mini: {
    Tomato: 'mini-red.png',
    Blueberry: 'mini-blue.png',
    Banana: 'mini-yellow.png',
    Avocado: 'mini-green.png'
  }
};

// Обработчик события кнопки Random
btnRandom.addEventListener('click', function() {
  userMessage.innerHTML = 'Guess who will be the winner!<br />';
  btnRandom.disabled = true;
  btnReset.disabled = false;
  btnStart.disabled = true;

  const brands = Object.keys(carImages);
  const colors = Object.keys(carImages[brands[0]]);
  const speeds = [4, 5, 6, 7];
  let availableBrands = [...brands];
  let availableColors = [...colors];
  let availableSpeeds = [...speeds];
  

  // Создаем массив для хранения ссылок на изображения машинок
  if (arrCars.length < 4) {
    for (let i = 0; i < 4; i++) {
      const brandIndex = Math.floor(Math.random() * availableBrands.length);
      const brand = availableBrands.splice(brandIndex, 1)[0];
      const colorIndex = Math.floor(Math.random() * availableColors.length);
      const color = availableColors.splice(colorIndex, 1)[0];
      const speedIndex = Math.floor(Math.random() * availableSpeeds.length);
      const speed = availableSpeeds.splice(speedIndex, 1)[0];
      const imageSrc = carImages[brand][color];

      const carImageRaceTrack = document.createElement('img');
      carImageRaceTrack.src = "img/" + imageSrc;
      raceTrack.appendChild(carImageRaceTrack);

      const carImageUserMsg = document.createElement('img');
      carImageUserMsg.src = "img/" + imageSrc;
      userMessage.appendChild(carImageUserMsg);

      const car = {
        brand: brand,
        color: color,
        speed: speed,
        imageOnTrack: carImageRaceTrack,
        imageForGuess: carImageUserMsg,
        positionX: 10
      };
      arrCars.push(car);
    }

    let firstCar = arrCars[0].imageForGuess;
    let secondCar = arrCars[1].imageForGuess;
    let thirdCar = arrCars[2].imageForGuess;
    let fourthCar = arrCars[3].imageForGuess;
    

    firstCar.addEventListener('click', function() {
      userGuess = (arrCars[0].color + ' ' + arrCars[0].brand);
      userMessage.innerHTML =
          `You think <span class='guess'>${userGuess}</span> will win?<br />Press Start and let's see!`;
      userMessage.appendChild(firstCar);
      btnStart.disabled = false;
    });    

    secondCar.addEventListener('click', function() {
      userGuess = (arrCars[1].color + ' ' + arrCars[1].brand);
      userMessage.innerHTML =
          `You think <span class='guess'>${userGuess}</span> will win?<br />Press Start and let's see!`;
      userMessage.appendChild(secondCar);
      btnStart.disabled = false;
    });

    thirdCar.addEventListener('click', function() {
      userGuess = (arrCars[2].color + ' ' + arrCars[2].brand);
      userMessage.innerHTML =
          `You think <span class='guess'>${userGuess}</span> will win?<br />Press Start and let's see!`;
      userMessage.appendChild(thirdCar);
      btnStart.disabled = false;
    });

    fourthCar.addEventListener('click', function() {
      userGuess = (arrCars[3].color + ' ' + arrCars[3].brand);
      userMessage.innerHTML =
          `You think <span class='guess'>${userGuess}</span> will win?<br />Press Start and let's see!`;
      userMessage.appendChild(fourthCar);
      btnStart.disabled = false;
    });
  }
});

// Обработчик события кнопки Reset
btnReset.addEventListener('click', function() {
  btnRandom.disabled = false;
  btnReset.disabled = true;
  btnStart.disabled = true;

  resetBG();
  arrCars = [];
  arrWinners = [];

  userMessage.innerHTML = 'One more time?<img src="img/chiwawa2.png" />';

  const carsOnTrack = document.querySelectorAll('#race__track img');
  carsOnTrack.forEach(function(carImageRaceTrack) {
    carImageRaceTrack.remove();
  });
  
});

// Обработчик события кнопки Start
btnStart.addEventListener('click', function() {
  if (arrCars.length === 4) {
    btnRandom.disabled = true;
    btnReset.disabled = true;
    btnStart.disabled = true;
    userMessage.innerHTML =
        `Your choice is:<br/><span class='guess'>${userGuess}</span><img src="img/chiwawa3.png" />`;

    function moveCar(car) {
      let posCar = car.positionX;
      let carSpeed = parseInt(car.speed);

      function move() {
        posCar += carSpeed;
        car.positionX = posCar;

        if (posCar >= finish) {
          car.positionX = finish;

          const newWinner = {
            brand: car.brand,
            color: car.color,
            speed: car.speed,
            imageOnTrack: car.imageOnTrack,
            imageForGuess: car.imageForGuess,
            positionX: finish,
            };

          arrWinners.push(newWinner);
          stopBG();
        } else {
          car.imageOnTrack.style.left = posCar + 'px';
          if (posCar < finish) {
            requestAnimationFrame(move);
          }
        }

        // Проверяем, завершена ли гонка и выводим сообщение о результате
        if(arrWinners.length === 4) {
          // First place is for the first element of the winners array ect
            btnReset.disabled = false;
            // 
            if(userGuess === (arrWinners[0].color + ' ' + arrWinners[0].brand)) {
              userMessage.innerHTML =
                  '<span class="red">✩✰☆ You won! ☆✰✩</span><br /><br />' +
                  '<span class="first__place">First place: ' + arrWinners[0].color +
                  ' ' + arrWinners[0].brand + '</span><br>Second place: ' + arrWinners[1].color +
                  ' ' + arrWinners[1].brand + '<br>Third place: ' + arrWinners[2].color +
                  ' ' + arrWinners[2].brand;
            } else {
              userMessage.innerHTML = "<span class='blue'>You didn't win ☹️</span><br /><br />" +
                  "<span class='first__place'>First place: " + arrWinners[0].color +
                  ' ' + arrWinners[0].brand + '</span><br>Second place: ' + arrWinners[1].color +
                  ' ' + arrWinners[1].brand + '<br>Third place: ' + arrWinners[2].color +
                  ' ' + arrWinners[2].brand;
            }
        };
      }
      move();
    }

    arrWinners = [];
    arrCars.forEach(moveCar);
    moveBG();
  }
});

// Функция движения фона
let posBG = 0;
let bgAnimation;

function moveBG() {
  
  posBG -= 3.1;
  raceTrack.style.backgroundPositionX = posBG + 'px';
  bgAnimation = requestAnimationFrame(moveBG);
}

function stopBG() {
  cancelAnimationFrame(bgAnimation);
  posBG = 0;
}

function resetBG() {
  cancelAnimationFrame(bgAnimation);
  raceTrack.style.backgroundPositionX = '0px';
  posBG = 0;
}

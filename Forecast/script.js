'use strict'

// Default State
document.getElementById('btn__weather').disabled = true;
document.getElementById('btn__graphic').disabled = true;
document.getElementById('btn__clear').disabled = true;

document.getElementById('input__city').addEventListener('input', function() {

    if (document.getElementById('input__city').value) {
        document.getElementById('btn__weather').disabled = false;
    }
});

// Button Weather
document.getElementById('btn__weather').addEventListener('click', function() {

    clearTable();
    fetchWeather(document.getElementById('input__city').value, document.getElementById('input__city'));

    document.getElementById('btn__graphic').disabled = false;
    document.getElementById('btn__clear').disabled = false;
});

// Key Enter
document.addEventListener('keydown', (event) => {

    if (event.key === 'Enter') {
        event.preventDefault();
        document.getElementById('btn__weather').click();
    }
});

function fetchWeather (city, inputElement) {

    fetch(`https://www.prevision-meteo.ch/services/json/${city}`)

        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })

        .then(fetchedData => {

                inputElement.value = '';

                // Creation City Title
                const cityTitle = document.createElement('h3');
                cityTitle.textContent = fetchedData.city_info.name + ', ' + fetchedData.current_condition.date;
                cityTitle.classList.add('city-title');
                document.getElementById('div__header').appendChild(cityTitle);

                // Creation Table
                const weatherTable = document.createElement('table');
                weatherTable.classList.add('weather');
                const weatherTableHead = document.createElement('thead');
                const weatherTableBody = document.createElement('tbody');

                weatherTable.appendChild(weatherTableHead);
                weatherTable.appendChild(weatherTableBody);
                document.getElementById('div__weather').appendChild(weatherTable);

                // Creation Table Headers
                const headerRow = weatherTableHead.insertRow();

                ['Day', 'Weather', 'T min', 'T max'].forEach(element => {
                    const headerCell = document.createElement('th');
                    headerCell.textContent = element;
                    headerRow.appendChild(headerCell);
                });

                // Creating Days Array
                let arrDays = [];
                Object.values(fetchedData).forEach(element => {
                    if (element.hasOwnProperty("day_short")) {
                    arrDays.push(element);
                    }
                });

                // Creating Table With Data
                arrDays.forEach(element => {
                    const row = weatherTableBody.insertRow();

                    const conditionCellContent = document.createElement('div');
                    const conditionText = document.createElement('span');
                    const conditionIcon = document.createElement('img');

                    conditionText.textContent = element.condition;
                    conditionIcon.src = element.icon;
                    conditionIcon.alt = element.condition;
                    conditionIcon.title = element.condition;

                    conditionCellContent.appendChild(conditionText);
                    conditionCellContent.appendChild(conditionIcon);

                    const cellValues = [
                        element.day_long,
                        conditionCellContent,
                        element.tmin + '℃',
                        element.tmax + '℃'
                    ];

                    cellValues.forEach((value, index) => {
                        let cell = row.insertCell(index);
                        if (value instanceof HTMLElement) {
                            cell.appendChild(value);
                        } else {
                            cell.textContent = value;
                        }
                    });
                });


                // Button Graphic
                    document.getElementById('btn__graphic').addEventListener('click', function() {

                        if (document.querySelector('table.graphic')) {
                            document.querySelector('table.graphic').remove();
                        }

                        // Creation Graphic Table
                        const graphicTable = document.createElement('table');
                        graphicTable.classList.add('graphic');
                        const graphicTableHead = document.createElement('thead');
                        const graphicTableBody = document.createElement('tbody');

                        graphicTable.appendChild(graphicTableHead);
                        graphicTable.appendChild(graphicTableBody);
                        document.getElementById('div__graphic').appendChild(graphicTable);

                        let k = 30;
                        for (let i = 0; i < 4; i++) {
                            const graphicRow = graphicTable.insertRow();

                            for (let j = 0; j < 6; j++) {
                                const cell = graphicRow.insertCell();

                                if (j === 0) {
                                    cell.textContent = k + '℃';
                                    k -= 10;
                                } else if (i === 3 && j > 0) {
                                    const index = j - 1;

                                    if (index < arrDays.length) {
                                        const day = arrDays[index];

                                        const rectangleMin = document.createElement('div');
                                        rectangleMin.classList.add('rectangle__min');
                                        rectangleMin.style.height = day.tmin * 7.9 + 'px';
                                        cell.appendChild(rectangleMin);

                                        const textMin = document.createElement('div');
                                        textMin.classList.add('text__small');
                                        textMin.textContent = day.tmin;
                                        rectangleMin.appendChild(textMin);

                                        const rectangleMax = document.createElement('div');
                                        rectangleMax.classList.add('rectangle__max');
                                        rectangleMax.style.height = day.tmax * 7.9 + 'px';
                                        cell.appendChild(rectangleMax);

                                        const textMax = document.createElement('div');
                                        textMax.classList.add('text__small');
                                        textMax.textContent = day.tmax;
                                        rectangleMax.appendChild(textMax);
                                    }
                                }
                            }
                        }

                        const lastRow = graphicTable.insertRow();

                        for (let i = 0; i < 6; i++) {
                            const lastRowCell = lastRow.insertCell();

                                if (i === 0) {
                                    continue;
                                }

                                if (i === 5) {
                                    lastRowCell.innerHTML = arrDays[arrDays.length - 1].day_short;
                                    break;
                                }

                            lastRowCell.innerHTML = arrDays[i - 1].day_short;
                        }
                            document.getElementById('btn__graphic').disabled = true;
                    });
        })

        .catch(error => {
            console.error('Catched! Error loading JSON:', error.message);
            const errorTitle = document.createElement('h3');
            errorTitle.classList.add('alert');
            errorTitle.textContent = 'Not found';
            document.getElementById('div__header').appendChild(errorTitle);
            inputElement.value = '';
            document.getElementById('btn__graphic').disabled = true;
        });
};

// Button Clear
document.getElementById('btn__clear').addEventListener('click', function() {
    clearTable();
    console.clear();
});

function clearTable() {

    document.getElementById('btn__weather').disabled = true;
    document.getElementById('btn__graphic').disabled = true;
    document.getElementById('btn__clear').disabled = true;

    if (document.querySelector('table.graphic')) {
        document.querySelector('table.graphic').remove();
    }

    if (document.querySelector('h3.city-title') instanceof Element) {
        document.querySelector('h3.city-title').remove();
    }

    if (document.querySelector('table.weather')) {
        document.querySelector('table.weather').remove();
    }

    if (document.querySelector('h3.alert')) {
        document.querySelector('h3.alert').remove();
    }
};
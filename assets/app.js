import './styles/app.scss';

const $ = require('jquery');
require('bootstrap');

$(function() {
    $('[data-toggle="popover"]').popover();

    const searchFormV1 = document.getElementById("search-v1");
    const searchInputV1 = searchFormV1.querySelector("input");
    const searchFormV2 = document.getElementById("search-v2");
    const searchInputV2 = searchFormV2.querySelector("input");
    const resultsDiv = document.querySelector(".results");

    const fetchResult = (searchTerm, url, format) => {
        fetch(url, {
            method: 'GET',
            headers: {'Accept': format}
        })
        .then(response => response.json())
        .then(data => {
            const row = document.createElement("pre");
            row.innerHTML = JSON.stringify(data, undefined, 4);
            resultsDiv.appendChild(row);
        })
        .catch(error => console.error("Error fetching races:", error));
    }

    searchFormV1.addEventListener("submit", function(event) {
        event.preventDefault();
        const searchTerm = searchInputV1.value.trim();
        const url = searchFormV1.dataset.path + '?term=' + searchTerm;
        fetchResult(searchTerm, url, 'application/json');
        searchInputV1.value = '';
    });

    searchFormV2.addEventListener("submit", function(event) {
        event.preventDefault();
        const searchTerm = searchInputV2.value.trim();
        const url = searchFormV2.dataset.path + '?term=' + searchTerm;
        fetchResult(searchTerm, url, 'application/vnd.api+json');
        searchInputV2.value = '';
    });
});
import './styles/app.scss';

const $ = require('jquery');
require('bootstrap');

$(function() {
    $('[data-toggle="popover"]').popover();

    const searchForm = document.getElementById("search");
    const searchInput = searchForm.querySelector("input");
    const resultsDiv = document.querySelector(".results");

    const fetchResult = (searchTerm) => {
        const url = searchForm.dataset.action + '?term=' + searchTerm;

        fetch(url, {
            method: 'GET',
            headers: {'Accept': 'application/ld+json'}})
            .then(response => response.json())
            .then(data => {
                const row = document.createElement("p");
                row.innerHTML = JSON.stringify(data, null, 2);
                resultsDiv.appendChild(row);
            })
            .catch(error => console.error("Error fetching races:", error));
    }

    searchForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const term = searchInput.value.trim();
        fetchResult(term);
        searchInput.value = '';
    });
});
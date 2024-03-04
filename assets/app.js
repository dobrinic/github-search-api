import './styles/app.scss';

const $ = require('jquery');
require('bootstrap');

$(function() {
    $('[data-toggle="popover"]').popover();

});
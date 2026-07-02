<?php
function currency($amount) {
    return 'Rs ' . number_format($amount, 0);
}
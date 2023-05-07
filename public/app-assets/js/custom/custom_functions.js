function percentageCalculate(partialValue, totalValue) {
    if (totalValue > 0 && partialValue > 0) {
        return parseInt((100 * partialValue) / totalValue);
    } else {
        return 0;
    }
}

function digitFormat(totalValue) {
    if (totalValue < 1000) {
        return totalValue;
    } else if (totalValue >= 1000 && totalValue < 1000000) {
        return parseFloat(totalValue / 1000).toFixed(1) + "K";
    } else if (totalValue >= 1000000) {
        return parseFloat(totalValue / 1000000).toFixed(1) + "M";
    }
}

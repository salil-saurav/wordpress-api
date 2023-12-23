// DOM Manupulation 

document.addEventListener("DOMContentLoaded", () => {
    const propertyStatus = document.getElementById("property-status");
    const propertyInput = document.getElementById("property-input");
    const bedroom = document.getElementById("bedroom");
    const bathroom = document.getElementById("bathroom");
    const garage = document.getElementById("garage");
    const dateFilter = document.getElementById("date-filter");
    const resultCont = document.getElementById("fetched-result");
    const result = document.querySelectorAll(".result"); 

    const getSelectedOption = (selectElement) => {
        const selectedOption = selectElement.options[selectElement.selectedIndex].value;
        return selectedOption;
    }

    console.log(getSelectedOption(propertyStatus));
    console.log(getSelectedOption(bedroom));
    console.log(getSelectedOption(bathroom));

    propertyInput.addEventListener("input", () => {
        const inpVal = propertyInput.value;    

    })
})
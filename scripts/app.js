document.addEventListener("DOMContentLoaded", () => {
    const propertyStatus = document.getElementById("property-status");
    const bedroom = document.getElementById("bedroom");
    const bathroom = document.getElementById("bathroom");
    const car = document.getElementById("car");
    const propertyInput = document.getElementById("property-input");
    const result = document.querySelectorAll(".result");
    const allResult = document.getElementById("all-result");
    const soldResult = document.getElementById("sold-result");
    const buyResult = document.getElementById("buy-result");
    const sold = document.querySelectorAll(".sold");
    const buy = document.querySelectorAll(".buy");
    const selectSort = document.getElementById("date-filter");

    // const returnedDate = (res) => {
    //     const propDate = res.querySelector(".date").textContent.trim();
    //     const propUpdateTime = res.querySelector(".time").textContent.trim();
    //     const formattedDate = new Date(propDate);
    //     const formattedTime = new Date(propUpdateTime)
    // }

    // Flags

    let searchFlag;

    const getSelectedOption = (selectElement) => {
        const selectedOption =
            selectElement.options[selectElement.selectedIndex].value;
        return selectedOption.toLowerCase();
    };

    const setDisplayStyle = (result, display) => {
        result.style.display = display;
    };

    const sortProperty = (resultClass) => {
        const selected = getSelectedOption(selectSort);
        const elementsArray = Array.from(
            document.querySelectorAll(`.${resultClass}`)
        );

        elementsArray.sort((a, b) => {
            const dateA = new Date(a.querySelector(".date").textContent.trim());
            const dateB = new Date(b.querySelector(".date").textContent.trim());

            const priceFromA = parseFloat(
                a.querySelector(".lower").textContent.trim()
            );
            const priceToA = parseFloat(
                a.querySelector(".higher").textContent.trim()
            );

            const priceFromB = parseFloat(
                b.querySelector(".lower").textContent.trim()
            );
            const priceToB = parseFloat(
                b.querySelector(".higher").textContent.trim()
            );

            switch (selected) {
                case "newest":
                    return dateB - dateA;
                case "highest":
                    return (
                        Math.max(priceToB, priceFromB) -
                        Math.max(priceToA, priceFromA)
                    );
                case "lowest":
                    return (
                        Math.min(priceFromA, priceToA) -
                        Math.min(priceFromB, priceToB)
                    );
                case "oldest":
                    return dateA - dateB;
                default:
                    return 0;
            }
        });

        // allResult.innerHTML = "";
        // soldResult.innerHTML = "";
        // buyResult.innerHTML = "";

        elementsArray.forEach((element) => {
            allResult.appendChild(element);
            soldResult.appendChild(element);
            buyResult.appendChild(element);
        });
    };

    const sortHandler = () => {
        sortProperty("result");
        sortProperty("buy");
        sortProperty("sold");
    };

    const handleStatusChange = () => {
        const selectedOption = getSelectedOption(propertyStatus);

        switch (selectedOption) {
            case "all":
                setDisplayStyle(allResult, "flex");
                setDisplayStyle(buyResult, "none");
                setDisplayStyle(soldResult, "none");
                break;

            case "sold":
                setDisplayStyle(allResult, "none");
                setDisplayStyle(buyResult, "none");
                setDisplayStyle(soldResult, "flex");
                break;

            case "current":
                setDisplayStyle(allResult, "none");
                setDisplayStyle(soldResult, "none");
                setDisplayStyle(buyResult, "flex");
                break;

            default:
                break;
        }
    };

    const filterResult = (selected, inpVal) => {
        const addressText = selected
            .querySelector(".result-address")
            .textContent.trim()
            .toLowerCase();

        if (addressText.includes(inpVal)) {
            selected.style.display = "block";
        } else {
            selected.style.display = "none";
        }
    };

    const filterResultWithSelected = (result, element, className) => {
        const selectedValue = parseInt(getSelectedOption(element));
        const propValue = +result
            .querySelector(`.${className}`)
            .textContent.trim();

        if (result.style.display === "block") {
            if (!isNaN(selectedValue) && propValue >= selectedValue) {
                result.style.display = "block";
            } else {
                result.style.display = "none";
            }
        }
    };

    //  Bed bath car filter

    const handleInputChange = () => {
        const inputValue = propertyInput.value.trim().toLowerCase();
        searchFlag = !!inputValue;

        const filterAndDisplay = (results) => {
            results.forEach((res) => {
                filterResult(res, inputValue);
                res.style.display = !inputValue ? "block" : res.style.display;
            });
        };

        if (allResult.style.display === "flex") {
            filterAndDisplay(result);
        } else if (soldResult.style.display === "flex") {
            filterAndDisplay(sold);
        } else {
            filterAndDisplay(buy);
        }
    };

    const handleValChange = () => {
        result.forEach((res) =>
            filterResultWithSelected(res, bedroom, "bedroom")
        );
        sold.forEach((res) =>
            filterResultWithSelected(res, bedroom, "bedroom")
        );
        buy.forEach((res) => filterResultWithSelected(res, bedroom, "bedroom"));
    };
    const handleBathChange = () => {
        result.forEach((res) =>
            filterResultWithSelected(res, bathroom, "bathroom")
        );
        sold.forEach((res) =>
            filterResultWithSelected(res, bathroom, "bathroom")
        );
        buy.forEach((res) =>
            filterResultWithSelected(res, bathroom, "bathroom")
        );
    };
    const handleCarChange = () => {
        result.forEach((res) => filterResultWithSelected(res, car, "car"));
        sold.forEach((res) => filterResultWithSelected(res, car, "car"));
        buy.forEach((res) => filterResultWithSelected(res, car, "car"));
    };

    propertyInput.addEventListener("input", handleInputChange);
    propertyStatus.addEventListener("change", handleStatusChange);
    bedroom.addEventListener("change", handleValChange);
    bathroom.addEventListener("change", handleBathChange);
    car.addEventListener("change", handleCarChange);
    selectSort.addEventListener("change", sortHandler);
});

// DOM Manupulation

// document.addEventListener("DOMContentLoaded", () => {
//     const propertyStatus = document.getElementById("property-status");
//     const propertyInput = document.getElementById("property-input");
//     const bedroom = document.getElementById("bedroom");
//     const bathroom = document.getElementById("bathroom");
//     const garage = document.getElementById("garage");
//     const dateFilter = document.getElementById("date-filter");
//     const resultCont = document.getElementById("fetched-result");
//     const result = document.querySelectorAll(".result");
//     const resultAddress = document.querySelectorAll(".result-address");

//     const getSelectedOption = (selectElement) => {
//         const selectedOption =
//             selectElement.options[selectElement.selectedIndex].value;
//         return selectedOption.toLowerCase();
//     };

//     const filterResult = (selected) => {
//         const inpVal = propertyInput.value.trim().toLowerCase();
//         const addressText = selected
//             .querySelector(".result-address")
//             .textContent.trim()
//             .toLowerCase();

//         if (addressText.includes(inpVal)) {
//             selected.style.display = "block";
//         } else {
//             selected.style.display = "none";
//         }
//     };

//     if (getSelectedOption(propertyStatus) === "all") {
//         result.forEach((res) => {
//             res.style.display = "block";
//             propertyInput.addEventListener("input", () => {
//                 filterResult(res);
//             });
//         });
//     }
//     propertyStatus.addEventListener("change", () => {
//         if (getSelectedOption(propertyStatus) === "all") {
//             result.forEach((res) => {
//                 res.style.display = "block";
//                 propertyInput.addEventListener("input", () => {
//                     filterResult(res);
//                 });
//             });
//         } else if (getSelectedOption(propertyStatus) === "current") {
//             result.forEach((res) => {
//                 if (res.classList.contains("_current_")) {
//                     res.style.display = "block";
//                     propertyInput.addEventListener("input", () => {
//                         filterResult(res);
//                     });
//                 } else {
//                     res.style.display = "none";
//                 }
//             });
//         } else if (getSelectedOption(propertyStatus) === "sold") {
//             result.forEach((res) => {
//                 if (res.classList.contains("_sold_")) {
//                     res.style.display = "block";
//                     propertyInput.addEventListener("input", () => {
//                         filterResult(res);
//                     });
//                 } else {
//                     res.style.display = "none";
//                 }
//             });
//         }
//     });
// });

document.addEventListener("DOMContentLoaded", () => {
    const propertyStatus = document.getElementById("property-status");
    const propertyInput = document.getElementById("property-input");
    const result = document.querySelectorAll(".result");

    const getSelectedOption = (selectElement) => {
        const selectedOption =
            selectElement.options[selectElement.selectedIndex].value;
        return selectedOption.toLowerCase();
    };

    const filterResult = (selected) => {
        const inpVal = propertyInput.value.trim().toLowerCase();
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

    const handleInputChange = () => {
        result.forEach((res) => {
            filterResult(res);
        });
    };

    const handleStatusChange = () => {
        const selectedOption = getSelectedOption(propertyStatus);

        result.forEach((res) => {
            if (selectedOption === "all") {
                filterResult(res);
            } else {
                const statusClass = "_" + selectedOption + "_";
                if (res.classList.contains(statusClass)) {
                    res.style.display = "block";
                    // filterResult(res);
                } else {
                    res.style.display = "none";
                    // filterResult(res);
                }
            }
        });
    };

    // propertyInput.addEventListener("input", handleInputChange);
    propertyStatus.addEventListener("change", handleStatusChange);
});

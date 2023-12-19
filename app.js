// const data = require("./data.json");
// const parsedData = data.properties.property;

const username = "di.balich";
const password = "G$p%8S=es#Cx";
const url = "https://api.open2view.com/nz/properties.json?detail=full";
const urlWithID = `https://api.open2view.com/nz/properties/{id}.json`;

// Create a base64-encoded token from the username and password
const base64Token = btoa(`${username}:${password}`);

let parsedData = {};
let arrID = [];

async function fetchDataWithBasicAuth(url, username, password) {
    const base64Token = btoa(`${username}:${password}`);

    try {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                Authorization: `Basic ${base64Token}`,
                "Content-Type": "application/json",
            },
        });

        if (response.status === 401) {
            throw new Error("Authentication failed");
        } else if (!response.ok) {
            throw new Error("Request failed");
        }

        const data = await response.json();
        return data;
    } catch (error) {
        throw error;
    }
}

// Usage example

(async () => {
    try {
        const apiData = await fetchDataWithBasicAuth(url, username, password);
        const returedApiData = apiData.properties.property;
        const getTheData = (id) => {
            const found = returedApiData.find(obj => obj.id === id);
            if (found) {
                return found;
            } else {
                console.log("not found");
            }
        }
        console.log(getTheData(489532));
        returedApiData.forEach(element => {
            // console.log(element.videos);
            // console.log(element.id);
        });
    } catch (error) {
        console.error("Error:", error);
    }
})();

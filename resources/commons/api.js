import axios from "axios";

const API_BASE_URL = "http://localhost:8765/api";

const http = axios.create({
    baseURL: API_BASE_URL,
});

http.interceptors.response.use(
    (response) => {
        const { data } = response;

        if (!data.success) {
            return Promise.reject({
                message: data.message,
                errors: data.errors,
            });
        }
        return data.data;
    },
    (error) => {
        //   // Handle any errors that occurred during the request
        //   if (error.response) {
        //     // The request was made, but the server responded with an error status code
        //     console.error("Server error:", error.response.status, error.response.data);
        //   } else if (error.request) {
        //     // The request was made, but no response was received
        //     console.error("No response from the server:", error.request);
        //   } else {
        //     // Something happened in setting up the request that triggered an error
        //     console.error("Request error:", error.message);
        //   }
        //   // Return a rejected Promise with the error to propagate it to the calling code
        return Promise.reject(error);
    }
);

export default http;

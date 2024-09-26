const api = axios.create({
    baseURL: BASE_URL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
});

let requestInProgress = false;

api.interceptors.request.use(config => {
    requestInProgress = true;
    disableButtons();
    return config;
}, error => {
    requestInProgress = false;
    enableButtons();
    return Promise.reject(error);
});

api.interceptors.response.use(response => {
    requestInProgress = false;
    enableButtons();
    return response;
}, error => {
    requestInProgress = false;
    enableButtons();
    return Promise.reject(error);
});

const disableButtons = () => {
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => button.disabled = true);
};

const enableButtons = () => {
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => button.disabled = false);
};

export default api;

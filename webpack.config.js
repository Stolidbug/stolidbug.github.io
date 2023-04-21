const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/sylius/ui-bundle');
const build = require('./config-builder');

const backendConfig = build('backend', `./assets/backend/`, vendorUiPath); // for admin
const frontendConfig = build('frontend', `./assets/frontend`, vendorUiPath); // for frontend

//module.exports = [backendConfig]; // for admin only
// module.exports = [frontendConfig]; // for frontend only
module.exports = [backendConfig, frontendConfig]; // both frontend and admin

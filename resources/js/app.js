import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App'; // Votre composant principal

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}

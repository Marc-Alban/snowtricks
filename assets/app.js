import './styles/app.css';
import 'bootstrap';
import 'jquery';
import { startStimulusApp } from '@symfony/stimulus-bridge';
import '@symfony/autoimport';
export const app = startStimulusApp(require.context('./controllers', true, /\.(j|t)sx?$/));


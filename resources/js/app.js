import './bootstrap';
import '../css/app.css';
import 'preline';
import Swal from 'sweetalert2';

window.Swal = Swal;
document.addEventListener('livewire:navigated', () => { 
    window.HSStaticMethods.autoInit();
})
document.addEventListener('DOMContentLoaded', () => {
  eventListeners();
  darkMode();
});

const darkMode = () => {

  const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
  const botonDarkMode = document.querySelector('.dark-mode-boton')

  if(prefiereDarkMode.matches) {
    document.body.classList.add('darkmode');
  } else {
    document.body.classList.remove('darkmode');
  }

  prefiereDarkMode.addEventListener('change', ()=> {
    if(prefiereDarkMode.matches) {
    document.body.classList.add('darkmode');
    } else {
      document.body.classList.remove('darkmode');
    }    
  });

  botonDarkMode.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
  });
}

const eventListeners = () => {
  const mobileMenu = document.querySelector('.mobile-menu');

  mobileMenu.addEventListener('click', navegacionResponsive);
}

const navegacionResponsive = () => {
  const navegacion = document.querySelector('.navegacion');

  navegacion.classList.toggle('mostrar');
}
/*********************** AUTH SEARCH *****************************/
const searchInput = document.querySelector('#searchName');
const searchInput2 = document.querySelector('#searchEmail');
const searchIcon = document.querySelector('#searchIcon');
const searchIcon2 = document.querySelector('#searchIcon2');
const searchForm = document.querySelector('#searchForm');
const searchForm2 = document.querySelector('#searchForm2');
if (searchIcon) {
    searchIcon.addEventListener('click', function(event) {
      event.preventDefault(); 
      searchForm.submit();
    });
  }
  
  if (searchIcon2) {
    searchIcon2.addEventListener('click', function(event) {
      event.preventDefault(); 
      searchForm2.submit();
    });
  }
  
  if (searchInput) {
    searchInput.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
          event.preventDefault(); 
          searchForm.submit();
      }
    });
  }
  
  if (searchInput2) {
    searchInput2.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
          event.preventDefault(); 
          searchForm2.submit();
      }
    });
  }
  

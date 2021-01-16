/**
 * Set Sidebar State From LocalStorage to Class After Page Load
 */
window.onload = function() {
    const collapse = localStorage.getItem('sidebar_collapse');

    if(collapse == true){
         $('body').addClass('sidebar-collapse');
    } else if(collapse == false) {
         $('body').removeClass('sidebar-collapse');
    }
}

/**
 * Save State to LocalStorage if Toggle Click
 */
$('[data-widget="pushmenu"]').on('click', function() {
    const findClass = $('body').hasClass('sidebar-collapse');

    if(findClass == true){
        localStorage.setItem('sidebar_collapse', 0);
    } else {
        localStorage.setItem('sidebar_collapse', 1);
    }
})

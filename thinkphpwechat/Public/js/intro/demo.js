+function ($) {
  $(function(){
    
    var intro = introJs();

    intro.setOptions({
      steps: [
      {
          element: '.nav-user',
          intro: '<p class="h4 text-uc"><strong>1: Quick Bar</strong></p><p>This is the notification, search and user information quick tool bar</p>',
          position: 'bottom'
        },
        {
          element: '#nav header',
          intro: '<p class="h4 text-uc"><strong>2: Project switch</strong></p><p>You can quick switch your projects here.</p>',
          position: 'right'
        },
        {
          element: '#aside',
          intro: '<p class="h4 text-uc"><strong>3: Aside</strong></p><p>Aside guide here</p>',
          position: 'left'
        },        
        {
          element: '#nav footer',
          intro: '<p class="h4 text-uc"><strong>4: Chat & Friends</strong></p><p>Start chat with your friend.</p>',
          position: 'top'
        }
      ],
      showBullets: true,
    });

    intro.start();

  });
}(jQuery);
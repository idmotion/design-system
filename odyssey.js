<script>
// Deixa azul os elementos filho de uma lista para atuar como checkbox

document.addEventListener("DOMContentLoaded", function() {
  var lis = document.querySelectorAll('li > ul > li');
  lis.forEach(function(li) {
    li.addEventListener('click', function() {
      var currentColor = this.style.getPropertyValue('--bg-color');
      this.style.setProperty('--bg-color', currentColor === '#a3baff' ? '#eef2ff' : '#a3baff');
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
  var sidebar = document.getElementById('sidebar');
  var isMouseOver = false;
  var timeoutId;
  var sensitivity = 50; // Sensibilidade inicial

  // Verifica a posição do mouse e mostra/oculta a barra inferior
  function checkMousePosition(event) {
    var mouseY = event.clientY;
    var windowHeight = window.innerHeight;

    var bottomSensitivity = sensitivity; // Sensibilidade padrão

    // Verifica se a barra inferior está ativada
    if (isMouseOver) {
      bottomSensitivity = 200; // Aumenta a sensibilidade na parte inferior quando a barra inferior está ativada
    }

    if (mouseY >= windowHeight - bottomSensitivity) {
      showBars();
    } else {
      hideBarsWithDelay();
    }
  }

  // Mostra a barra inferior
  function showBars() {
    clearTimeout(timeoutId);
    if (sidebar) {
      sidebar.style.transform = 'translateX(-50%) translateY(0)';
    }
  }

  // Oculta a barra inferior com um pequeno atraso
  function hideBarsWithDelay() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
      if (sidebar) {
        sidebar.style.transform = 'translateX(-50%) translateY(100%)';
      }
    }, 200); // Ajuste o valor do atraso conforme necessário (em milissegundos)
  }

  // Ativa a barra inferior ao entrar na área
  if (sidebar) {
    sidebar.addEventListener('mouseenter', function() {
      isMouseOver = true;
      sensitivity = 200; // Aumenta a sensibilidade na parte inferior
    });

    // Desativa a barra inferior ao sair da área
    sidebar.addEventListener('mouseleave', function() {
      isMouseOver = false;
      sensitivity = 50; // Restaura a sensibilidade padrão
      hideBarsWithDelay();
    });
  }

  // Adiciona o evento de movimento do mouse
  document.addEventListener('mousemove', checkMousePosition);
});
</script>

<script>
    var itens = document.getElementsByTagName("li");

for (var i = 0; i < itens.length; i++) {
  itens[i].addEventListener("click", function(event) {
    event.target.classList.toggle("clicado");
  });
}

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var paragraphs = document.getElementsByTagName('p');

  for (var i = 0; i < paragraphs.length; i++) {
    var paragraph = paragraphs[i];
    var text = paragraph.innerHTML;
    var regex = /#[0-9A-Fa-f]{6}/g;
    var replacedText = text.replace(regex, function(match) {
      return '<span class="rectangle" style="background-color: ' + match + '"></span>' + match;
    });
    paragraph.innerHTML = replacedText;
  }
});
</script>

var tabLinks    = new Array();
var contentDivs = new Array();

function init()
{
    // Obtiene las pestañas y su contenido.
    var tabListItems = document.getElementById('tabs').childNodes;
    console.log(tabListItems);
    for (var i = 0; i < tabListItems.length; i ++)
    {
        if (tabListItems[i].nodeName == "LI")
        {
            var tabLink     = getFirstChildWithTagName(tabListItems[i], 'A');
            var id          = getHash(tabLink.getAttribute('href'));
            tabLinks[id]    = tabLink;
            contentDivs[id] = document.getElementById(id);
        }
    }

    // Activa los clics y selecciona la primera pestaña.
    var i = 0;

    for (var id in tabLinks)
    {
        tabLinks[id].onclick = showTab;
        tabLinks[id].onfocus = function () {
            this.blur()
        };
        if (i == 0)
        {
            tabLinks[id].className = 'active';
        }
        i ++;
    }

    // Muestra únicamente el primer contenido.
    var i = 0;

    for (var id in contentDivs)
    {
        if (i != 0)
        {
            console.log(contentDivs[id]);
            contentDivs[id].className = 'content hide';
        }
        i ++;
    }
}

function showTab()
{
    var selectedId = getHash(this.getAttribute('href'));

    // Muestra la pestaña seleccionada.
    for (var id in contentDivs)
    {
        if (id == selectedId)
        {
            tabLinks[id].className    = 'active';
            contentDivs[id].className = 'content';
        }
        else
        {
            tabLinks[id].className    = '';
            contentDivs[id].className = 'content hide';
        }
    }

    // Evita seguir el enlace.
    return false;
}

function getFirstChildWithTagName(element, tagName)
{
    for (var i = 0; i < element.childNodes.length; i ++)
    {
        if (element.childNodes[i].nodeName == tagName)
        {
            return element.childNodes[i];
        }
    }
}

function getHash(url)
{
    var hashPos = url.lastIndexOf('#');
    return url.substring(hashPos + 1);
}

function toggle(elem)
{
    elem = document.getElementById(elem);

    if (elem.style && elem.style['display'])
    {
        // Lee el estilo del elemento.
        var disp = elem.style['display'];
    }
    else if (elem.currentStyle)
    {
        // Compatibilidad con Internet Explorer.
        var disp = elem.currentStyle['display'];
    }
    else if (window.getComputedStyle)
    {
        // Lee el estilo calculado.
        var disp = document.defaultView.getComputedStyle(elem, null).getPropertyValue('display');
    }

    // Alterna la visibilidad.
    elem.style.display = disp == 'block' ? 'none' : 'block';

    return false;
}

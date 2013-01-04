mySettings = {
        onTab: { keepDefault: false, 
                 replaceWith: '    '},
	markupSet: [
		{name:'Жирный', key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Наклонный', key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Подчеркнутый', key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:'Зачеркнутый', key:'S', openWith:'[s]', closeWith:'[/s]'},
		{separator:'---------------' },
		{name:'Картинка', key:'P', replaceWith:'[img][![Введите адрес изображения]!][/img]'},
		{name:'Ссылка', key:'L', openWith:'[url=[![Введите адрес ссылки]!]]', closeWith:'[/url]', placeHolder:'Введите адрес ссылки'},
		{name:'YouTube', openWith:'[youtube][![Введите адрес ссылки "поделиться"]!][/youtube]'}
	]
}

news = {
        onTab: { keepDefault: false, 
                 replaceWith: '    '},
	markupSet: [
		{name:'Жирный', key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Наклонный', key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Подчеркнутый', key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:'Зачеркнутый', key:'S', openWith:'[s]', closeWith:'[/s]'},
		{separator:'---------------' },
		{name:'Картинка', key:'P', replaceWith:'[img][![Введите адрес изображения]!][/img]'},
		{name:'Ссылка', key:'L', openWith:'[url=[![Введите адрес ссылки]!]]', closeWith:'[/url]', placeHolder:'Введите адрес ссылки'},
		{name:'YouTube', openWith:'[youtube][![Введите адрес ссылки "поделиться"]!][/youtube]'},
                {separator:'---------------' },
                {name:'Разделение страницы', openWith:'[page]'}
	]
}
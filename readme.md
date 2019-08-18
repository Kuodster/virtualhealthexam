## Запуск проекта
1. git clone https://github.com/Kuodster/virtualhealthexam.git
2. выполнить: *composer install*
3. импортировать исходные таблицы в новую базу
4. поменять данные для доступа к базе в *.env*
5. выполнить: *php artisan migrate*

Миграция создаст новые таблицы (rel, source), добавит нужные индексы и скопирует туда данные из старых (игнорируя дубли записей из tb_rel).

Контроллер лежит в папке: *app/Http/Controllers/CollectionController.php*

## Ответы на вопросы задания

#### Каким образом можно получить все записи tb_source с title, начинающимся  на 'title 1' и с привязанным NDC­аттрибутом из табллицы tb_rel?
<pre>
SELECT
	tb_source.*,
	tb_rel.ndc 
FROM
	tb_source
	INNER JOIN tb_rel ON tb_rel.cx = tb_source.cx 
WHERE
	tb_source.title LIKE 'title 1%' 
	LIMIT 100
</pre>

LEFT JOIN - чтобы получить все записи из tb_source

#### Подсчитать кол­во записей в tb_source, имеющих более 2 одинаковых  вхождений по значениям поля NDC.

<pre>
SELECT
	* 
FROM
	tb_source 
WHERE
	tb_source.cx IN ( SELECT cx FROM tb_rel GROUP BY tb_rel.cx, tb_rel.ndc HAVING count( * ) > 1 )
</pre>

Вернёт все записи из tb_source с дублями поля NDC в tb_rel

#### Дать рекомендации по структуре таблиц и хранению данных:
- Добавить первичные ключи в таблицы. Будет удобнее управлять в будущем, если, к примеру, нужно будет реализовать управление данными.
- При условии, что поля останутся цифровыми - поменять поля cx / rx на bigint ( сейчас они varchar(10) ).
Индексы на таких полях будут работать немного быстрее, чем на varchar, но и размер таблицы станет больше.
- Добавить индексы на tb_source.cx, tb_rel.cx (tb_source.rx для сортировки)
- Добавить индекс на tb_source.title для фильтрации
- Удалить дубли записей из tb_rel и добавить уникальный индекс на (cx, ndc)




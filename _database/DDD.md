# Dictionnaire des données

## Oeuvre (artwork)
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|**id**|INT|Primary Key, NOT NULL, UNSIGNED, AI|ID de l'oeuvre|
|**name**|VARCHAR(255)|NOT NULL|Nom de l'oeuvre|
|**description**|TEXT|NOT NULL|Description de l'oeuvre|
|**author**|VARCHAR(255)|NOT NULL|Auteur de l'oeuvre|
|**created_in**|VARCHAR(255)|NOT NULL|Date de création de l'oeuvre|
|**posted_by**|VARCHAR(255)|NOT NULL|Auteur du post de l'oeuvre|
|**updated_by**|VARCHAR(255)|NULL|Auteur du post de l'oeuvre|
|**slug**|VARCHAR(255)|NOT NULL|Slug pour l'URL|
|**old_slugs**|JSON|NULL|Stocker les anciens slugs en cas d'édition pour redirection|
|**images**|??|NULL|A voir si on stock l'image en DB + comment faire si plusieurs images|
|**created_at**|TIMESTAMP|NOT NULL, CURRENT TIMESTAMP|Date d'ajout|
|**updated_at**|TIMESTAMP|NULL|Date de modification|
|**category_id**|ID|Foreign key, NOT NULL|ID de la categorie|
|**user_id**|ID|Foreign key, NOT NULL|ID de l'utilisateur|
|||||

## Catégorie (category)
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|**id**|INT|Primary Key, NOT NULL, UNSIGNED, AI|ID de la catégorie|
|**name**|VARCHAR(255)|NOT NULL|Nom de la catégorie|
|**description**|TEXT|NOT NULL|Description de la catégorie|
|**slug**|VARCHAR(255)|NOT NULL|Slug pour l'URL|
|**images**|??|NULL|A voir si on stock l'image en DB + comment faire si plusieurs images|
|||||

## Utilisateur (user)
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|**id**|INT|Primary Key, NOT NULL, UNSIGNED, AI|ID type|
|**email**|VARCHAR(255)|NOT NULL, UNIQUE|Email de l'utilisateur|
|**password**|VARCHAR(64)|NOT NULL|Mot de passe de l'utilisateur|
|**role**|VARCHAR(64)|NOT NULL|Role de l'utilisateur|
|||||

________

## MOCODO

```
CATEGORY: id_category, name, description, images?
ARTWORK_CATEGORY, 11 ARTWORK, 0N CATEGORY: id_artwork, id_category

:
ARTWORK: id_artwork, name, description, author, created_in, slug, old_slugs?, images?, posted_by, updated_by, created_at, updated_at

USER: id_user, email, password, roles
USER_ARTWORK, 0N USER, 01 ARTWORK: id_user, id_artwork
```
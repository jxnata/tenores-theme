# Documentação do Tema Tenores

## Índice

1. [Visão Geral](#visão-geral)
2. [Acessando as Configurações do Tema](#acessando-as-configurações-do-tema)
3. [Configurações Gerais](#configurações-gerais)
4. [Gerenciando Produtos (Cursos)](#gerenciando-produtos-cursos)
5. [Gerenciando Conteúdo](#gerenciando-conteúdo)
6. [Sistema de Acesso de Membros](#sistema-de-acesso-de-membros)
7. [Login com Google](#login-com-google)
8. [Menus e Navegação](#menus-e-navegação)
9. [Shortcodes Disponíveis](#shortcodes-disponíveis)
10. [Depoimentos](#depoimentos)
11. [Webinar](#webinar)
12. [Curso em Destaque](#curso-em-destaque)

---

## Visão Geral

O tema Tenores é um tema WordPress desenvolvido especificamente para a plataforma de cursos. Ele oferece:

-   **Loja de cursos** integrada com WooCommerce
-   **Sistema de acesso restrito** para conteúdo exclusivo de membros
-   **Login com Google** para facilitar o cadastro de usuários
-   **Página inicial personalizável** com seções modulares
-   **Gerenciamento completo** através do painel administrativo do WordPress

---

## Acessando as Configurações do Tema

Para acessar as configurações do tema:

1. Faça login no painel administrativo do WordPress
2. No menu lateral esquerdo, vá em **Aparência > Configurações do Tema**
3. Você verá todas as opções organizadas em seções

> **Nota:** Você precisa ter permissões de editor ou administrador para acessar essas configurações.

---

## Configurações Gerais

### Banner da Página Inicial

**O que faz:** Define a imagem de fundo da seção principal (hero) da página inicial.

**Como configurar:**

1. Clique em **"Selecionar imagem"**
2. Escolha uma imagem da biblioteca de mídia ou faça upload de uma nova
3. A imagem será exibida como fundo da seção principal da homepage

**Dica:** Use imagens de alta qualidade (recomendado: 1920x1080px ou maior) para melhor visualização em todos os dispositivos.

---

### Headline (Título Principal)

**O que faz:** Define o texto principal exibido na seção hero da página inicial.

**Como configurar:**

1. Digite o texto desejado no campo
2. Você pode usar HTML básico para formatação:
    - `<strong>` para texto em negrito
    - `<em>` para texto em itálico
    - `<span class="text-primary">` para destacar com a cor primária (laranja)
    - `<br>` para quebra de linha

**Exemplo:**

```
Fala Autêntica <strong class="text-primary">Resultados</strong> Reais
```

---

### Email de Contato

**O que faz:** Define o email de contato exibido no rodapé do site.

**Como configurar:**

1. Digite o endereço de email completo
2. O email aparecerá como um link clicável no rodapé

---

### Telefone de Contato

**O que faz:** Define o telefone de contato exibido no rodapé do site.

**Como configurar:**

1. Digite o número de telefone no formato desejado
2. O telefone aparecerá como um link clicável no rodapé (abre o aplicativo de telefone em dispositivos móveis)

**Exemplo:** `+55 (11) 99999-9999`

---

### URL do CTA (Call to Action)

**O que faz:** Define o link do botão principal "QUERO MEU ACESSO" que aparece no cabeçalho e em outras seções do site.

**Como configurar:**

1. Digite a URL completa (ex: `https://tenores.com.br/minha-conta?action=register`)
2. Pode ser uma página interna do WordPress ou um link externo
3. O botão aparecerá no cabeçalho e na seção de oferta da página inicial

---

### Máximo de Parcelas

**O que faz:** Define o número máximo de parcelas exibido nos produtos e na seção de oferta.

**Como configurar:**

1. Digite um número entre 1 e 36
2. Este valor será usado para calcular o valor das parcelas nos produtos
3. Exemplo: Se o produto custa R$ 1.200,00 e você definir 12 parcelas, será exibido "12x de R$ 100,00"

---

### Redes Sociais

**O que faz:** Define os links das redes sociais que aparecem no site.

**Redes disponíveis:**

-   **URL do LinkedIn**
-   **URL do Facebook**
-   **URL do Instagram**
-   **URL do YouTube**

**Como configurar:**

1. Para cada rede social, digite a URL completa do seu perfil/página
2. Exemplo: `https://linkedin.com/in/seu-perfil`
3. Os ícones das redes sociais aparecerão na lateral do banner

**Nota:** Se deixar algum campo vazio, o ícone correspondente não será exibido.

---

### Menus do Rodapé

**O que faz:** Define quais menus aparecem no rodapé do site.

**Menus disponíveis:**

-   **Menu Principal do Footer:** Menu exibido na primeira seção do rodapé
-   **Menu Secundário do Footer:** Menu exibido na segunda seção do rodapé (se configurado)

**Como configurar:**

1. Primeiro, crie os menus em **Aparência > Menus**
2. Depois, selecione os menus desejados nos campos correspondentes
3. Se não selecionar nenhum menu, a seção não será exibida

**Como criar um menu:**

1. Vá em **Aparência > Menus**
2. Clique em **"Criar um novo menu"**
3. Dê um nome ao menu (ex: "Menu Footer Principal")
4. Adicione itens ao menu (páginas, posts, links personalizados, etc.)
5. Clique em **"Salvar menu"**
6. Volte em **Configurações do Tema** e selecione o menu criado

---

## Gerenciando Produtos (Cursos)

### Adicionando um Novo Curso

1. No menu lateral, vá em **Produtos > Adicionar novo**
2. Preencha as informações básicas:

    - **Nome do produto:** Título do curso
    - **Descrição curta:** Texto que aparece na página do produto (resumo)
    - **Descrição:** Descrição completa do curso (aparece abaixo na página do produto)

3. **Configurações de Preço:**

    - **Preço regular:** Preço original do curso
    - **Preço de venda:** Preço promocional (opcional)
    - Se definir um preço de venda, o desconto será calculado automaticamente

4. **Imagens do Produto:**

    - **Imagem do produto:** Imagem principal (aparece na listagem e na página do produto)
    - **Galeria de imagens:** Imagens adicionais (a primeira imagem da galeria será usada como banner na página do produto)

5. **Duração do Curso:**

    - No campo **"Duração do curso"**, informe a duração (ex: "Duração de 30 meses")
    - Esta informação aparecerá na página do produto

6. **Controle de Acesso:**

    - Selecione quem pode acessar este produto:
        - **Público - Acesso livre:** Qualquer pessoa pode ver e comprar
        - **Apenas Membros - Usuários registrados:** Apenas usuários logados podem ver e comprar
        - **Apenas Membros com Compras - Usuários que já compraram:** Apenas usuários que já fizeram pelo menos uma compra podem ver e comprar

7. Clique em **"Publicar"** para salvar o curso

---

### Editando um Curso Existente

1. Vá em **Produtos > Todos os produtos**
2. Clique no curso que deseja editar
3. Faça as alterações necessárias
4. Clique em **"Atualizar"**

---

### Excluindo um Curso

1. Vá em **Produtos > Todos os produtos**
2. Passe o mouse sobre o curso desejado
3. Clique em **"Lixeira"**
4. Para excluir permanentemente, vá em **Lixeira** e clique em **"Excluir permanentemente"**

---

### Categorias de Produtos

**O que são:** Categorias ajudam a organizar seus cursos.

**Como criar:**

1. Vá em **Produtos > Categorias**
2. Digite o nome da categoria (ex: "Oratória", "Comunicação", etc.)
3. Clique em **"Adicionar nova categoria"**

**Como atribuir a um produto:**

1. Ao editar um produto, no painel lateral direito, marque a categoria desejada
2. Um produto pode ter múltiplas categorias

---

## Gerenciando Conteúdo

### Criando um Post (Artigo)

1. Vá em **Posts > Adicionar novo**
2. Digite o título do post
3. Escreva o conteúdo no editor
4. **Imagem destacada:** Adicione uma imagem que aparecerá na listagem de posts
5. **Categorias e Tags:** Organize o post em categorias e tags
6. **Controle de Acesso:** No painel lateral, defina quem pode acessar este post:
    - **Acesso livre:** Qualquer pessoa pode ver
    - **Apenas Membros:** Apenas usuários logados podem ver
    - **Apenas Membros com Compras:** Apenas usuários que já compraram podem ver
7. Clique em **"Publicar"**

---

### Criando uma Página

1. Vá em **Páginas > Adicionar nova**
2. Digite o título da página
3. Escreva o conteúdo
4. **Controle de Acesso:** Defina quem pode acessar (mesmo sistema dos posts)
5. Clique em **"Publicar"**

**Dica:** Você pode usar shortcodes nas páginas para adicionar funcionalidades especiais (veja seção de Shortcodes).

---

## Sistema de Acesso de Membros

O tema possui um sistema de controle de acesso que permite restringir conteúdo para diferentes níveis de usuários.

### Níveis de Acesso

1. **Acesso Livre (Público):**

    - Qualquer pessoa pode ver o conteúdo, mesmo sem estar logada

2. **Apenas Membros:**

    - Apenas usuários registrados e logados no site podem ver
    - Usuários não logados verão uma mensagem pedindo para fazer login ou criar conta

3. **Apenas Membros com Compras:**
    - Apenas usuários que já fizeram pelo menos uma compra no site podem ver
    - Usuários sem compras verão a mensagem de acesso restrito

### Onde Aplicar o Controle de Acesso

-   **Posts:** Ao criar ou editar um post, você verá um painel "Controle de Acesso" no lado direito
-   **Páginas:** Mesmo sistema dos posts
-   **Produtos:** Ao criar ou editar um produto, há um campo "Controle de Acesso" nas configurações do produto

### Mensagem de Acesso Restrito

Quando um usuário tenta acessar conteúdo restrito sem ter permissão, ele verá uma mensagem personalizável.

**Como personalizar a mensagem:**

1. Vá em **Aparência > Configurações do Tema**
2. Na seção **"Acesso de Membros"**, você pode editar:
    - **Título da mensagem de acesso restrito:** Título exibido quando o acesso é negado
    - **Subtítulo da mensagem de acesso restrito:** Texto explicativo abaixo do título

---

## Login com Google

O tema permite que usuários façam login ou se registrem usando sua conta do Google, facilitando o processo de cadastro.

### Configurando o Login com Google

**Pré-requisito:** Você precisa ter um projeto no Google Cloud Console e criar credenciais OAuth.

**Passo a passo:**

1. **Criar credenciais no Google Cloud Console:**

    - Acesse [Google Cloud Console](https://console.cloud.google.com/)
    - Crie um novo projeto ou selecione um existente
    - Vá em **APIs e Serviços > Credenciais**
    - Clique em **"Criar credenciais" > "ID do cliente OAuth"**
    - Configure o tipo de aplicativo (aplicativo da web)
    - Adicione a URI de redirecionamento (você encontrará esta URI nas configurações do tema)

2. **Configurar no WordPress:**

    - Vá em **Aparência > Configurações do Tema**
    - Na seção **"Login com Google"**:
        - Marque **"Ativar login com Google"**
        - Cole o **Client ID** obtido no Google Cloud Console
        - Cole o **Client Secret** obtido no Google Cloud Console
        - Copie a **URI de Redirecionamento** exibida e adicione no Google Cloud Console

3. **Adicionar URI no Google Cloud Console:**

    - Volte ao Google Cloud Console
    - Edite as credenciais OAuth criadas
    - Adicione a URI de redirecionamento copiada do WordPress na lista de URIs autorizadas

4. Clique em **"Salvar alterações"** nas configurações do tema

**Como funciona:**

-   Usuários verão um botão "Entrar com Google" na página de login/cadastro
-   Ao clicar, serão redirecionados para o Google para autorizar
-   Após autorizar, serão automaticamente registrados (se novo) ou logados (se já tiverem conta) no site
-   O sistema usa o email do Google para identificar usuários existentes

---

## Menus e Navegação

### Criando o Menu Principal

O menu principal aparece no cabeçalho do site.

1. Vá em **Aparência > Menus**
2. Clique em **"Criar um novo menu"**
3. Dê um nome ao menu (ex: "Menu Principal")
4. Adicione itens ao menu:
    - **Páginas:** Selecione páginas existentes
    - **Posts:** Adicione posts individuais
    - **Links personalizados:** Adicione URLs externas
    - **Categorias:** Adicione categorias de posts ou produtos
5. Arraste os itens para reorganizar a ordem
6. No campo **"Configurações do menu"**, marque **"Menu Principal"** (Primary Menu)
7. Clique em **"Salvar menu"**

**Nota:** O link da página inicial aparece automaticamente como um ícone de casa em telas maiores.

---

### Menu do Rodapé

Veja a seção **"Menus do Rodapé"** em Configurações Gerais para configurar os menus do rodapé.

---

## Shortcodes Disponíveis

Shortcodes são códigos especiais que você pode inserir em páginas ou posts para adicionar funcionalidades.

### [tenores_oferta]

**O que faz:** Exibe a seção de oferta com preços e benefícios do curso em destaque.

**Como usar:**

1. Ao editar uma página ou post, digite: `[tenores_oferta]`
2. A seção completa será exibida no local onde você inseriu o shortcode

**Onde usar:** Útil para criar páginas de vendas ou landing pages com a oferta do curso.

---

### [tenores_posts_membros]

**O que faz:** Exibe uma lista de posts exclusivos para membros.

**Como usar:**

```
[tenores_posts_membros]
```

**Atributos opcionais:**

-   **posts:** Número de posts a exibir (padrão: 5)

    ```
    [tenores_posts_membros posts="10"]
    ```

-   **category:** Filtrar por categoria (use o slug da categoria)

    ```
    [tenores_posts_membros category="dicas" posts="3"]
    ```

-   **tag:** Filtrar por tag (use o slug da tag)
    ```
    [tenores_posts_membros tag="oratoria" posts="5"]
    ```

**Comportamento:**

-   **Usuários não logados:** Verão a mensagem de acesso restrito
-   **Usuários logados:** Verão os posts marcados como "Apenas Membros"
-   **Usuários com compras:** Verão posts de "Apenas Membros" e "Apenas Membros com Compras"

**Exemplos:**

```
[tenores_posts_membros]
[tenores_posts_membros posts="10"]
[tenores_posts_membros category="dicas" posts="3"]
[tenores_posts_membros tag="oratoria" posts="5"]
```

---

## Depoimentos

O tema possui um tipo de conteúdo especial para depoimentos de clientes/alunos.

### Adicionando um Depoimento

1. Vá em **Depoimentos > Adicionar novo**
2. Digite o **título** (geralmente o nome da pessoa)
3. No editor, escreva o **texto do depoimento**
4. **Imagem destacada:** Adicione a foto da pessoa (opcional)
5. No campo **"Função / Cargo"**, digite a função ou cargo da pessoa (ex: "Fundadora da Black Sisters in Law")
6. Clique em **"Publicar"**

**Onde aparecem:** Os depoimentos são exibidos na seção de depoimentos da página inicial.

---

## Webinar

Você pode configurar um banner promocional de webinar na página inicial.

### Configurando o Webinar

1. Vá em **Aparência > Configurações do Tema**
2. Na seção **"Webinar"**:
    - **Mostrar webinar:** Marque esta opção para exibir o banner
    - **Data do webinar:** Digite a data no formato AAAA-MM-DD (ex: 2026-03-15)
    - **URL do webinar:** Digite o link para inscrição ou página do webinar
3. Clique em **"Salvar alterações"**

**Onde aparece:** O banner do webinar aparece na página inicial, logo após a seção principal (hero).

**Para desativar:** Desmarque a opção **"Mostrar webinar"**.

---

## Curso em Destaque

Você pode destacar um curso específico na loja e na página inicial.

### Configurando o Curso em Destaque

1. Vá em **Aparência > Configurações do Tema**
2. Na seção **"Curso em Destaque"**:
    - **Produto em destaque:** Selecione o curso que deseja destacar
    - **Banner promocional:** Adicione uma imagem de banner (aparece na página da loja)
    - **Título:** Digite o título que aparecerá no banner (ex: "Destrave Sua Voz, Liberte Seu Potencial")
    - **Subtítulo:** Digite o subtítulo/descrição que aparecerá no banner
3. Clique em **"Salvar alterações"**

**Onde aparece:**

-   **Página da Loja:** O banner do curso em destaque aparece no topo da página de produtos
-   **Página Inicial:** O curso em destaque é usado na seção de oferta

---

## Dicas e Boas Práticas

### Imagens

-   **Banner da página inicial:** Use imagens de alta qualidade (1920x1080px ou maior)
-   **Imagens de produtos:** Use imagens quadradas ou retangulares (recomendado: 800x800px ou 1200x800px)
-   **Imagens destacadas de posts:** Use imagens horizontais (recomendado: 1200x630px)

### Conteúdo

-   **Descrições curtas:** Seja objetivo e direto
-   **Descrições completas:** Use formatação (negrito, listas) para facilitar a leitura
-   **SEO:** Use títulos descritivos e relevantes

### Preços

-   **Preços promocionais:** Defina sempre um preço regular e um preço de venda para mostrar o desconto
-   **Parcelas:** O número de parcelas é configurado globalmente, mas você pode ajustar por produto se necessário

### Acesso Restrito

-   **Posts públicos:** Use para conteúdo de marketing e blog geral
-   **Apenas Membros:** Use para conteúdo de valor que incentiva o cadastro
-   **Apenas Membros com Compras:** Use para conteúdo exclusivo de alunos

---

## Suporte e Ajuda

Se você tiver dúvidas ou precisar de ajuda:

1. Consulte esta documentação primeiro
2. Verifique se todas as configurações estão corretas
3. Entre em contato com o desenvolvedor do tema: https://jxnata.github.io

---

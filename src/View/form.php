<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cidadão</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>  
    <div class="container">
        <h1>Cadastrar Cidadão</h1>
        <form action="/citizen/register" method="POST">
            <input 
                type="text" 
                name="name" 
                placeholder="Nome completo do cidadão" 
                required 
                pattern="\s*\S+\s+\S+.*" 
                title="Insira o nome completo do cidadão."
            >
            <button type="submit">Cadastrar</button>
        </form>

        <h1>Buscar Cidadão por NIS</h1>
        <form action="/citizen/search" method="GET">
            <input 
                type="text" 
                name="nis" 
                placeholder="Digite o NIS" 
                maxlength="11" 
                pattern="\d{11}" 
                title="NIS deve conter exatamente 11 dígitos numéricos" 
                required
            >
            <button type="submit">Buscar</button>
        </form>
    </div>
</body>
</html>
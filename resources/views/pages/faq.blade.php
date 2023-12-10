@extends('layouts.app')

@section('main')
    <main id="about-us">
        <section id="faq">
        <h1 id="faq-title">Frequently Asked Questions</h1>
        <details>
            <summary>Qual é o propósito do Community Connect?</summary>
            <p>Community Connect é um sistema de informação web-based que permite aos utilizadores partilharem perguntas e obterem respostas sobre diversos temas, tendo como intuito fornecer respostas para problemas comuns, num ambiente de interajuda solidária.</p>
        </details>
        <details>
            <summary>Como posso participar?</summary>
            <p>Para participar, basta criar uma conta gratuita. Clique no botão de Sign Up, preencha as informações necessárias e comece a explorar e interagir com as comunidades.</p>
        </details>  
        <details>
            <summary>Posso participar em várias comunidades ao mesmo tempo?</summary>
            <p>Sim, os utilizadores autênticados podem participar de várias comunidades em simultâneo. Isso permite que criar um feed pessoal personalizado.</p>
        </details>
        <details>
            <summary>Como faço para fazer uma pergunta?</summary>
            <p>Clique no botão "Ask a Question". Insira o título, o conteúdo e a comunidade que quer inserir a sua pergunta.</p>
        </details>
        <details>
            <summary>Posso votar em perguntas e respostas?</summary>
            <p>Sim, a plataforma incentiva a interação dos utilizadores autenticados colocando like/dislike em perguntas e respostas. Isso ajuda a destacar as perguntas e respostas mais relevantes e úteis.</p>
        </details>
        <details>
            <summary>Como é calculado o rating de um utilizador autenticado?</summary>
            <p>Os ratings são calculados usando os likes e dislikes das respostas de um utilizador dentro de cada comunidade.</p>
        </details>
        </section>
    </main>
@endsection


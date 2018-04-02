function [f] = filtrado(iduser)
%% Aplicaciones en Internet
%  Filtrado Colaborativo para Recomendaci�n
%
%  Instrucciones
%  ------------
%
%  Este fichero contiene codigo que te ayudar� a ir realizando la 
%  practica. En ella debes modificar la siguiente funci�n :
%
%     cofiCostFunc.m
%
%  En esta pr�ctica no debes modificar este fichero, excepto en la Parte 6,
%  en la que introduciras las peliculas y las puntuaciones que desees.
%

%% =============== Parte 1: Cargar dataset ================
%  Comenzaremos cargando el dataset de pel�culas para entender la estructura
%  de los datos.
%  
fprintf('Cargamos el dataset.\n\n');

%  Load data
[R,Y,movieList] = getData();


%% ================== Parte 7: Entrenar el algoritmo ====================
%  Ahora se entrenar� el algortimo de filtrado colaborativo para 
% 1682 pel�culas y 943 usuarios
%

fprintf('\nEntrenando el filtrado colaborativo...\n');

%  Valores utiles
num_users = size(Y, 2);
num_movies = size(Y, 1);
num_features = 100;

% Inicializa par�metros (Theta, X)
X = randn(num_movies, num_features);
Theta = randn(num_users, num_features);

initial_parameters = [X(:); Theta(:)];

% Selecciona las opciones de fmincg
%options = optimset('GradObj', 'on', 'MaxIter', 100);

% Ajusta regularizaci�n y ejecuta la optimizaci�n
lambda = 1.5;
theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, ...
                            num_features, lambda)), ...
                initial_parameters,100);
%theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, ...
%                               num_features, lambda)), ...
%               initial_parameters, options);

% Extrae X y Theta del vector resultante de la optimizaci�n (theta)
X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
Theta = reshape(theta(num_movies*num_features+1:end), ...
                num_users, num_features);

fprintf('Aprendizaje del sistema de recomendaci�n finalizado.\n');

fprintf('\nPrograma detenido. Pulse enter para continuar.\n');

%% ================== Parte 8: Generando recomendaciones ====================
%  Tras entrenar el algoritmo podemos realizar recomendaciones a partir de
%  la matriz de puntuaciones generada
%

p = X * Theta';
my_predictions = p(:,iduser).*(R(:,iduser)==0);
%my_predictions = p(:,1);

movieList = loadMovieList();

[r, ix] = sort(my_predictions, 'descend');
fprintf('\nTop te recomendamos:\n');
for i=1:8
    j = ix(i);
    fprintf('Puntuacion estimada %.1f para la pel�cila %s\n', my_predictions(j), ...
            movieList{j});
    query = sprintf('INSERT INTO recs (user_id, movie_id, rec_score) VALUES (%d, %d, %f)\n', iduser, j, my_predictions(j));
    updateRecommendation(query);
end

f = true;
end





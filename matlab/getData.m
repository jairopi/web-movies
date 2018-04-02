function [R,Y,movieList] = getData()


%% Añadir javapath
javaaddpath('/Users/sergio/Documents/MATLAB/TrabajoAI/mysql-connector-java-5.1.40-bin.jar');

%% Conectarse a la base de datos
d = com.mysql.jdbc.Driver;
urlValid = d.acceptsURL('jdbc:mysql://localhost:3306/movies');  %Should return true
props = java.util.Properties;
props.put('user','root'); props.put('password','root');
conn = d.connect('jdbc:mysql://localhost:3306/movies',props);

%% Realizar consultas
% stmt = conn.createStatement();
% result = stmt.executeQuery('SELECT * FROM users');
% col_count = result.getMetaData().getColumnCount();
% 
% data = [];
% while result.next()
%     disp('----- OTRO USER -----');
%     for i=1:col_count
%         disp(result.getString(i));
%     end
% end

%% Obtener numero de peliculas y usuarios
stmt2 = conn.createStatement();
result2 = stmt2.executeQuery('SELECT COUNT(*) FROM movie');

result2.next();
num_movies = result2.getInt(1);

stmt3 = conn.createStatement();
result3 = stmt3.executeQuery('SELECT COUNT(DISTINCT(id_user)) FROM user_score');

result3.next();
num_users = result3.getInt(1);

close(result2);
close(result3);

%% Obtener matrices R e Y
stmt = conn.createStatement();
result = stmt.executeQuery('SELECT id_user,id_movie,score FROM user_score');

Y = zeros(num_movies,num_users);

while result.next()
    Y(result.getInt(2),result.getInt(1))= result.getDouble(3);
end

R = logical(Y);

close(result);

%% Obtener movieList
stmt1 = conn.createStatement();
result1 = stmt1.executeQuery('SELECT id,title FROM movie');

movieList = cell([num_movies,1]);

while result1.next()
    movieList{result1.getInt(1)} = result1.getString(2);
end

close(result1);
close(conn);
end




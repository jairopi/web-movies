function [] = updateRecommendation(query)


%% Añadir javapath
javaaddpath('/Users/sergio/Documents/MATLAB/TrabajoAI/mysql-connector-java-5.1.40-bin.jar');

%% Conectarse a la base de datos
d = com.mysql.jdbc.Driver;
urlValid = d.acceptsURL('jdbc:mysql://localhost:3306/movies');  %Should return true
props = java.util.Properties;
props.put('user','root'); props.put('password','root');
conn = d.connect('jdbc:mysql://localhost:3306/movies',props);

%% Guardar predicciones en la base de datos
stmt = conn.createStatement();
result = stmt.executeUpdate(query);


close(stmt);
close(conn);

end
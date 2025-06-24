CREATE OR REPLACE PROCEDURE disconnect_expired_services()
LANGUAGE plpgsql
AS $$
DECLARE
    v_service RECORD;
    v_debt NUMERIC;
BEGIN
    FOR v_service IN 
        SELECT sa.id_connection, sa.id_services, sa.id_user, s.tariff_price
        FROM service_activation sa
        JOIN services s ON sa.id_services = s.id_services
        WHERE sa.date_disconnection IS NULL
        AND sa.date_connection < CURRENT_DATE - INTERVAL '1 month'
    LOOP
        -- Расчет долга (например, за 2 месяца просрочки)
        v_debt := v_service.tariff_price * 2;
        
        -- Помечаем услугу как отключенную
        UPDATE service_activation
        SET date_disconnection = CURRENT_DATE
        WHERE id_connection = v_service.id_connection;
        
        -- Создаем счет
        INSERT INTO invoices (
            id_services,
            id_user,
            sum_payment,
            date_formation,
            status_payment
        ) VALUES (
            v_service.id_services,
            v_service.id_user,
            v_debt,
            CURRENT_DATE,
            FALSE -- Не оплачено
        );
             RAISE NOTICE 'Услуга % отключена. Долг: % руб.', v_service.id_connection, v_debt;
    END LOOP;
    
    COMMIT;
END;
$$;
